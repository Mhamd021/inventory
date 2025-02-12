<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_info',
        'post_image',
    ];

    protected $appends = [
        'comments_count',
        'likes_count',
        'has_liked'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->with('user:id,name,user_image')->latest();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class)->with('user:id,name');
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getHasLikedAttribute()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function customToArray()
    {
        return [
            'id' => $this->id,
            'post_info' => $this->post_info,
            'post_image' => $this->post_image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comments_count' => $this->comments_count,
            'likes_count' => $this->likes_count,
            'has_liked' => $this->has_liked,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'user_image' => $this->user->user_image
            ]
        ];
    }

}
