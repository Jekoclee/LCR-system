<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomReview;
use Illuminate\Http\Request;

class RoomReviewsController extends Controller
{
    public function index(Request $request)
    {
        $q = RoomReview::with(['user', 'adminUser'])->latest();
        if ($request->filled('room_id')) {
            $q->where('room_id', (int) $request->input('room_id'));
        }
        if ($request->filled('q')) {
            $q->where('review', 'like', '%' . $request->input('q') . '%');
        }
        if ($request->filled('rating')) {
            $q->where('rating', (int) $request->input('rating'));
        }
        if ($request->filled('user_id')) {
            $q->where('user_id', (int) $request->input('user_id'));
        }
        $reviews = $q->paginate(15)->appends($request->query());
        $roomsMap = $this->fetchRoomNames($reviews->pluck('room_id')->unique()->values()->all());
        return view('admin.room_reviews.index', compact('reviews', 'roomsMap'));
    }

    protected function fetchRoomNames(array $roomIds): array
    {
        if (empty($roomIds)) {
            return [];
        }
        $names = [];
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if ($con) {
            $ids = implode(',', array_map('intval', $roomIds));
            $sql = "SELECT id, name FROM rooms WHERE id IN ($ids)";
            if ($res = mysqli_query($con, $sql)) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $names[(int) $row['id']] = $row['name'];
                }
            }
            mysqli_close($con);
        }
        return $names;
    }

    public function edit(RoomReview $roomReview)
    {
        $roomsMap = $this->fetchRoomNames([$roomReview->room_id]);
        return view('admin.room_reviews.edit', compact('roomReview', 'roomsMap'));
    }

    public function update(Request $request, RoomReview $roomReview)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
            'admin_reply' => 'nullable|string|max:2000',
        ]);
        $roomReview->rating = $data['rating'];
        $roomReview->review = $data['review'];
        if (array_key_exists('admin_reply', $data)) {
            $reply = trim((string) $data['admin_reply']);
            if ($reply === '') {
                $roomReview->admin_reply = null;
                $roomReview->admin_reply_user_id = null;
                $roomReview->admin_reply_at = null;
            } else {
                $roomReview->admin_reply = $reply;
                $roomReview->admin_reply_user_id = auth()->id();
                $roomReview->admin_reply_at = now();
            }
        }
        $roomReview->save();
        return redirect()->route('admin.room-reviews.index')->with('success', 'Review updated successfully!');
    }

    public function destroy(RoomReview $roomReview)
    {
        $roomReview->delete();
        return back()->with('success', 'Review deleted.');
    }
}
