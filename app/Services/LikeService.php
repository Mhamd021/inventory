<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post ;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class LikeService
{
    public function toggleLike($postId)
    {

        $user = User::find(auth()->user()->id);
        $post = Cache::remember("post_{$postId}", 60, function () use ($postId) {
            return Post::find($postId);
        });

        $like = $user->likes()->where('post_id', $postId)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        }
        else
        {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $postId,
            ]);
            $liked = true;
        }

        $likes_count = $post->likes_count;

        return ['liked' => $liked, 'likes_count' => $likes_count] ;
    }
}
