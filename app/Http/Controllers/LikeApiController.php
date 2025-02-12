<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LikeApiController extends Controller
{

    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function userlikes(User $user)
    {
        $likes = $user->likes;
        return response()->json(
            [
                'likes' => $likes
            ]
        );
    }

    public function toggleLike($postId)
    {
        $result = $this->likeService->toggleLike($postId);
        return response()->json($result);
    }



    public function hasLiked(Post $post)
    {
        $userId = auth('sanctum')->user()->id;
        $postId = $post->id;
        $like = Like::where('user_id', $userId)->where('post_id', $postId)->first();
        return response()->json([
            'liked' => $like ? true : false
        ]);
    }
}
