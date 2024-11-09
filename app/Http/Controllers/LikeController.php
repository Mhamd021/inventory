<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\HasApiTokens;


class LikeController extends Controller
{

    public function postlikes(Post $post)
    {
        $likes = $post->likes;

        return response()->json(
            [
                'count' => $likes->count(),
            ]
        );
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

    public function store(Request $request)
    {

        $like = Like::create(
            [
                'user_id' => auth('sanctum')->user()->id,
                'post_id' => $request->post_id
            ]
        );
        return response()->json(['like' => $like]);
    }

    public function destroy(Like $like)
    {
        $like->delete();
        return response()->json([
            'message' => 'success'
        ]);
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
