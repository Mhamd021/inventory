<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use \Staudenmeir\LaravelMergedRelations\Eloquent\HasMergedRelationships;
use Laravel\Cashier\Billable;



class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasMergedRelationships, Billable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'user_image',
        'bio',
        'user_gender',
        'birth_date',
        'cover_image',
    ];


    protected $hidden = [
        'password',
        'remember_token',
        'is_admin',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasmany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasmany(Comment::class);
    }
    public function likes(): HasMany
    {
        return $this->hasmany(Like::class)->with('post');
    }

    public function hasLiked($postId)
    {
        return $this->likes()->where('post_id',$postId)->exists();
    }

    // here the view is faster than the query builder so it stays related to the view

    // public function friends($userId)
    // {
    //     $friends = DB::table('users')->join('friends', function ($join) use ($userId) {
    //         $join->on('users.id', '=', 'friends.user_id')->orOn('users.id', '=', 'friends.friend_id');
    //     })->where(function ($query) use ($userId) {
    //         $query->where('friends.user_id', $userId)->orWhere('friends.friend_id', $userId);
    //     })->where('users.id', '!=', $userId)->select('users.id', 'users.name', 'friends.status')->get();
    //     return $friends;
    // }

    public function friends()
    {
        return $this->mergedRelationWithModel(User::class, 'friends_view');
    }

    public function friendsTo(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function friendsFrom(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function pendingFriendsTo()
    {
        return $this->friendsTo()->wherePivot('status', 'pending');
    }

    public function pendingFriendsFrom()
    {
        return $this->friendsFrom()->wherePivot('status', 'pending');
    }

    public function acceptedFriendsTo()
    {
        return $this->friendsTo()->wherePivot('status', 'accepted');
    }

    public function acceptedFriendsFrom()
    {
        return $this->friendsFrom()->wherePivot('status', 'accepted');
    }

    public function BlockedUsers()
    {
        return $this->friendsTo()->wherePivot('status', 'blocked');
    }
}
