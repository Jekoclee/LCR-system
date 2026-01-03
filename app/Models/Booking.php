<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'ref',
        'name',
        'email',
        'check_in',
        'check_out',
        'guests',
        'room_id',
        'proof_url',
        'notes',
        'status',
    ];
}
