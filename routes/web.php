<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Mail\WelcomeMail;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::post('/search', function (Request $request) {
    $data = $request->validate([
        'destination' => 'required|string|max:255',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
        'guests' => 'required|integer|min:1',
    ]);
    session(['search' => $data]);

    return redirect()->route('rooms')->with('status', 'Hotel search submitted');
})->name('hotels.search');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify.post');

Route::get('/mail/test', function () {
    $email = env('MAIL_USERNAME');
    if (!$email) {
        return response('MAIL_USERNAME is not set', 500);
    }
    $user = new User(['name' => 'Mail Test', 'email' => $email]);
    $code = (string) random_int(100000, 999999);
    Mail::to($email)->send(new WelcomeMail($user, $code));

    return 'Sent';
})->name('mail.test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/bookings', function () {
        return view('bookings');
    })->name('bookings');
});
Route::get('/book', function (Request $request) {
    $roomId = (int) $request->query('room_id', 0);
    $search = session('search', []);
    $payload = [
        'room_id' => $roomId,
        'check_in' => $search['check_in'] ?? $request->query('check_in'),
        'check_out' => $search['check_out'] ?? $request->query('check_out'),
        'guests' => $search['guests'] ?? $request->query('guests', 1),
    ];
    $rooms = [];
    $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
    if ($con) {
        $sql = 'SELECT r.id, r.name,
                (SELECT image FROM room_images WHERE room_id=r.id AND thumb=1 LIMIT 1) AS thumb_img,
                (SELECT image FROM room_images WHERE room_id=r.id LIMIT 1) AS any_img
                FROM rooms r
                WHERE r.removed=0 AND r.status=1
                ORDER BY r.name ASC';
        if ($res = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_assoc($res)) {
                $img = $row['thumb_img'] ?: $row['any_img'] ?: 'room1.jpg';
                $base = asset('images/rooms') . '/';
                $primary = $base . rawurlencode($img);
                $rooms[] = ['id' => (int) $row['id'], 'name' => $row['name'], 'img' => $primary, 'units' => null];
            }
        }
        $unitsCol = null;
        $cands = ['units', 'room_units', 'room_unit', 'quantity', 'qty', 'stock'];
        foreach ($cands as $c) {
            $exists = @mysqli_query($con, "SHOW COLUMNS FROM `rooms` LIKE '" . mysqli_real_escape_string($con, $c) . "'");
            if ($exists && mysqli_num_rows($exists) > 0) {
                $unitsCol = $c;
                break;
            }
        }
        if ($unitsCol) {
            $map = [];
            $ur = @mysqli_query($con, "SELECT id, `" . $unitsCol . "` AS u FROM `rooms` WHERE removed=0 AND status=1 ORDER BY id ASC");
            if ($ur) {
                while ($r = mysqli_fetch_assoc($ur)) {
                    $map[(int) $r['id']] = (int) $r['u'];
                }
            }
            foreach ($rooms as $i => $r) {
                $rooms[$i]['units'] = $map[$r['id']] ?? null;
            }
            $rooms = array_values(array_filter($rooms, function ($r) {
                return is_null($r['units']) || $r['units'] > 0;
            }));
        }
        mysqli_close($con);
    }

    return view('bookings', ['booking' => $payload, 'rooms' => $rooms]);
})->name('book.start');

Route::post('/book/submit', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', 'regex:/@gmail\.com$/i'],
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'guests' => 'required|integer|min:1|max:10',
        'room_id' => 'required|integer|min:1',
        'payment_proof' => 'required|file|image|mimes:jpeg,jpg,png,webp|max:4096',
        'notes' => 'nullable|string|max:500',
    ]);
    $dir = public_path('payment_proofs');
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    $file = $request->file('payment_proof');
    $ext = strtolower($file->getClientOriginalExtension());
    $ref = now()->format('YmdHis') . '-' . Str::random(6);
    $name = 'proof-' . $ref . '.' . $ext;
    $file->move($dir, $name);
    $url = asset('payment_proofs/' . $name);

    // Remove the file object as it cannot be serialized
    unset($data['payment_proof']);

    $bookingData = array_merge($data, ['ref' => $ref, 'proof_url' => $url]);

    $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
    if ($con) {
        $rid = (int) $bookingData['room_id'];
        $unitsCol = null;
        $cands = ['units', 'room_units', 'room_unit', 'quantity', 'qty', 'stock'];
        foreach ($cands as $c) {
            $exists = @mysqli_query($con, "SHOW COLUMNS FROM `rooms` LIKE '" . mysqli_real_escape_string($con, $c) . "'");
            if ($exists && mysqli_num_rows($exists) > 0) {
                $unitsCol = $c;
                break;
            }
        }
        if ($unitsCol) {
            $res = @mysqli_query($con, "SELECT `" . $unitsCol . "` AS u FROM `rooms` WHERE `id`=" . $rid . " LIMIT 1");
            $row = $res ? mysqli_fetch_assoc($res) : null;
            $u = isset($row['u']) ? (int) $row['u'] : 0;
            if ($u <= 0) {
                mysqli_close($con);
                return back()->with('status', 'Room unavailable. Units exhausted.');
            }
            $ok = @mysqli_query($con, "UPDATE `rooms` SET `" . $unitsCol . "`=" . ($u - 1) . " WHERE `id`=" . $rid . " LIMIT 1");
            if (!$ok) {
                mysqli_close($con);
                return back()->with('status', 'Unable to update room units. Try again.');
            }
        }
        mysqli_close($con);
    }

    // Save to Database
    Booking::create($bookingData);

    session(['last_booking' => $bookingData]);

    // Send Notification Email
    try {
        Mail::to($data['email'])->send(new \App\Mail\BookingPendingMail($bookingData));
    } catch (\Exception $e) {
        // Log error or silently fail if mail server not configured
    }

    return redirect()->route('book.start', [
        'room_id' => $data['room_id'],
        'check_in' => $data['check_in'],
        'check_out' => $data['check_out'],
        'guests' => $data['guests'],
    ])->with('status', 'Booking request submitted. Reference: ' . $ref)->with('proof_url', $url);
})->name('book.submit');

Route::get('/rooms', function () {
    $rooms = [];
    $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
    if ($con) {
        $sql = 'SELECT r.id, r.name, r.description,
                (SELECT image FROM room_images WHERE room_id=r.id AND thumb=1 LIMIT 1) AS thumb_img,
                (SELECT image FROM room_images WHERE room_id=r.id LIMIT 1) AS any_img
                FROM rooms r
                WHERE r.removed=0 AND r.status=1
                ORDER BY r.id ASC';
        if ($res = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_assoc($res)) {
                $img = $row['thumb_img'] ?: $row['any_img'] ?: 'room1.jpg';
                $base = asset('images/rooms') . '/';
                $primary = $base . rawurlencode($img);
                $imgs = [];
                $ir = mysqli_query($con, 'SELECT image FROM room_images WHERE room_id=' . (int) $row['id'] . ' ORDER BY thumb DESC, sr_no ASC');
                if ($ir) {
                    while ($r = mysqli_fetch_assoc($ir)) {
                        $imgs[] = $base . rawurlencode($r['image']);
                    }
                }
                if (empty($imgs)) {
                    $imgs[] = $primary;
                }
                $rooms[] = [
                    'id' => (int) $row['id'],
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'primary_img' => $primary,
                    'images' => $imgs,
                    'units' => null,
                ];
            }
        }
        $unitsCol = null;
        $cands = ['units', 'room_units', 'room_unit', 'quantity', 'qty', 'stock'];
        foreach ($cands as $c) {
            $exists = @mysqli_query($con, "SHOW COLUMNS FROM `rooms` LIKE '" . mysqli_real_escape_string($con, $c) . "'");
            if ($exists && mysqli_num_rows($exists) > 0) {
                $unitsCol = $c;
                break;
            }
        }
        if ($unitsCol) {
            $map = [];
            $ur = @mysqli_query($con, "SELECT id, `" . $unitsCol . "` AS u FROM `rooms` WHERE removed=0 AND status=1 ORDER BY id ASC");
            if ($ur) {
                while ($r = mysqli_fetch_assoc($ur)) {
                    $map[(int) $r['id']] = (int) $r['u'];
                }
            }
            foreach ($rooms as $i => $r) {
                $rooms[$i]['units'] = $map[$r['id']] ?? null;
            }
        }
        mysqli_close($con);
    }

    foreach ($rooms as $i => $r) {
        $stats = \App\Models\RoomReview::where('room_id', $r['id'])->selectRaw('AVG(rating) as avg_rating, COUNT(*) as count')->first();
        $rooms[$i]['rating_avg'] = $stats->avg_rating;
        $rooms[$i]['rating_count'] = $stats->count;
    }

    return view('rooms', ['rooms' => $rooms]);
})->name('rooms');

Route::get('/rooms/{id}', function ($id) {
    $room = null;
    $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
    if ($con) {
        $id = (int) $id;
        $sql = "SELECT * FROM rooms WHERE id=$id AND removed=0 AND status=1 LIMIT 1";
        if ($res = mysqli_query($con, $sql)) {
            $room = mysqli_fetch_assoc($res);
        }

        if ($room) {
            // Fetch images
            $imgs = [];
            $base = asset('images/rooms') . '/';
            $ir = mysqli_query($con, "SELECT image FROM room_images WHERE room_id=$id ORDER BY thumb DESC, sr_no ASC");
            if ($ir) {
                while ($r = mysqli_fetch_assoc($ir)) {
                    $imgs[] = $base . rawurlencode($r['image']);
                }
            }
            if (empty($imgs)) {
                $imgs[] = $base . 'room1.jpg'; // fallback
            }
            $room['images'] = $imgs;

            // Fetch Features
            $features = [];
            $fr = mysqli_query($con, "SELECT f.name FROM features f INNER JOIN room_features rf ON f.id = rf.features_id WHERE rf.room_id = $id");
            if ($fr) {
                while ($f = mysqli_fetch_assoc($fr)) {
                    $features[] = $f['name'];
                }
            }
            $room['features'] = $features;

            // Fetch Facilities
            $facilities = [];
            $facr = mysqli_query($con, "SELECT f.name, f.icon FROM facilities f INNER JOIN room_facilities rf ON f.id = rf.facilities_id WHERE rf.room_id = $id");
            if ($facr) {
                while ($f = mysqli_fetch_assoc($facr)) {
                    $facilities[] = $f;
                }
            }
            $room['facilities'] = $facilities;
        }
        mysqli_close($con);
    }

    if (!$room) {
        abort(404);
    }

    $reviews = \App\Models\RoomReview::with(['user','adminUser'])->where('room_id', $id)->latest()->get();
    $avgRating = $reviews->avg('rating');

    return view('room_details', ['room' => $room, 'reviews' => $reviews, 'avgRating' => $avgRating]);
})->name('room.details');

Route::post('/rooms/{id}/review', function (Request $request, $id) {
    $data = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string|max:1000',
    ]);

    if (!auth()->check()) {
        return back()->with('error', 'You must be logged in to post a review.');
    }

    \App\Models\RoomReview::create([
        'room_id' => (int) $id,
        'user_id' => auth()->id(),
        'rating' => $data['rating'],
        'review' => $data['review'],
    ]);

    return back()->with('status', 'Thank you for your review!');
})->name('room.review')->middleware('auth');
Route::get('/facilities', function () {
    return view('facilities');
})->name('facilities');
Route::get('/contact', function () {
    $contact = [];
    $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
    if ($con) {
        $q = 'SELECT * FROM `contact_details` WHERE `sr_no` = 1';
        if ($res = mysqli_query($con, $q)) {
            $contact = mysqli_fetch_assoc($res);
        }
        mysqli_close($con);
    }

    return view('contact', ['contact' => $contact]);
})->name('contact');

Route::post('/contact/send', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
    if ($con) {
        // Safe parameter binding using prepared statements would be better, but sticking to the pattern:
        // Note: For raw mysqli without prepared statements in this extensive closure context, simple escaping:
        $name = mysqli_real_escape_string($con, $data['name']);
        $email = mysqli_real_escape_string($con, $data['email']);
        $subject = mysqli_real_escape_string($con, $data['subject']);
        $msg = mysqli_real_escape_string($con, $data['message']);

        $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`, `date`, `seen`) VALUES ('$name', '$email', '$subject', '$msg', NOW(), 0)";
        mysqli_query($con, $q);
        mysqli_close($con);

        return back()->with('status', 'Email sent successfully!');
    }

    return back()->with('status', 'Error sending message. Try again later.');
})->name('contact.send');
Route::get('/dining/sabina-restaurant', function () {
    return view('dining.sabina');
})->name('dining.sabina');
Route::get('/events', function () {
    return view('events');
})->name('events');

Route::get('/rules', function () {
    return view('rules');
})->name('rules');

// Admin Routes
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', App\Http\Controllers\Admin\UserManagementController::class)->middleware('role:superadmin');

    Route::get('/admins', function () {
        return redirect()->route('admin.users.index', ['role' => 'admin']);
    })->name('admins.index')->middleware('role:superadmin');

    Route::get('/admins/create', function () {
        return view('admin.users.create', ['presetRole' => 'admin']);
    })->name('admins.create')->middleware('role:superadmin');

    // Booking Management
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{booking}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.update-status');

    // Rooms Management
    Route::get('/rooms', [App\Http\Controllers\Admin\RoomsController::class, 'index'])->name('rooms.index');
    Route::post('/rooms/{id}', [App\Http\Controllers\Admin\RoomsController::class, 'update'])->name('rooms.update');
    Route::post('/rooms', [App\Http\Controllers\Admin\RoomsController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{id}', [App\Http\Controllers\Admin\RoomsController::class, 'updateFull'])->name('rooms.update-full');
    Route::delete('/rooms/{id}', [App\Http\Controllers\Admin\RoomsController::class, 'destroy'])->name('rooms.destroy');

    // Room Reviews Management
    Route::resource('room-reviews', App\Http\Controllers\Admin\RoomReviewsController::class);

    // User Inquiries Management
    Route::get('/inquiries', [App\Http\Controllers\Admin\InquiriesController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{id}', [App\Http\Controllers\Admin\InquiriesController::class, 'show'])->name('inquiries.show');
    Route::put('/inquiries/{id}/seen', [App\Http\Controllers\Admin\InquiriesController::class, 'markSeen'])->name('inquiries.mark-seen');
    Route::delete('/inquiries/{id}', [App\Http\Controllers\Admin\InquiriesController::class, 'destroy'])->name('inquiries.destroy');
    Route::post('/inquiries/{id}/reply', [App\Http\Controllers\Admin\InquiriesController::class, 'reply'])->name('inquiries.reply');
});
