<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\WelcomeMail;

Route::get('/', function () {
    return view('home');
});

Route::post('/search', function (Request $request) {
    $data = $request->validate([
        'destination' => 'required|string|max:255',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
        'guests' => 'required|integer|min:1',
    ]);

    return back()->with('status', 'Hotel search submitted');
})->name('hotels.search');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

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
