<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

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
        $post_user_id = $like->post->user_id;
        if(auth('sanctum')->user()->id == $post_user_id || auth('sanctum')->user()->id == $like->user_id)
        {
            $like->delete();
            return response()->json([
                'message' => 'success'
            ]);
        }
        else
        {
            return response()->json(
                [
                    'message' => 'you are not authorized to delete this comment'
                ]
            );
        }

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
