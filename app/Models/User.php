<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    use HasFactory, Notifiable,HasApiTokens,HasMergedRelationships,Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts() : HasMany
    {
        return $this->hasmany(Post::class);
    }

    public function comments() : HasMany
    {
        return $this->hasmany(Comment::class);
    }
    public function likes() : HasMany
    {
        return $this->hasmany(Like::class)->with('post');
    }

    public function friends()
    {
        return $this->mergedRelationWithModel(User::class, 'friends_view');
    }

    public function friendsTo() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function friendsFrom() : BelongsToMany
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
