<?php

namespace App\Models;
use App\FriendStatus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    protected $casts =
    [
        'status' => FriendStatus::class ,
    ];
    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
    ];


}
