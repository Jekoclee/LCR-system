<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomReview extends Model
{
    protected $fillable = ['room_id', 'user_id', 'rating', 'review', 'admin_reply', 'admin_reply_user_id', 'admin_reply_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_reply_user_id');
    }
}
