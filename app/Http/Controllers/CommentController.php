<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Events\CommentOnPost;
use App\Http\Resources\Comment as CommentResource;

class CommentController extends Controller
{
    /**
     * Display a listing of post comments.
     */
    public function postcomments(Post $post)
    {
        $post = Post::findorfail($post->id);
        $comments = $post->comments;
        if($comments)
        {

            return response([
                "comments" => CommentResource::collection($comments)
            ]);

        }
        else
        {
            return response([
                "comments" => "there are no comments on this posts"
            ]);
        }


    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'comment_info' => ['bail','required','string'],
        ]);

      $comment =  Comment::create([
            'comment_info' => $request->comment_info,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,

        ]);

        event(new CommentOnPost($comment));

        return response([
            "message" => "comment created successfully",
            "comment" => new CommentResource($comment)
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        if($comment)
        {
            return response([
                "comment" => new CommentResource($comment)
            ]);
        }
        else
        {
            return response([
                "error" => 'there are no comments'
            ]);
        }

    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'comment_info' => ['bail','required','string'],
        ]);
        $comment->comment_info = $request->comment_info;
        $comment->save();
        return response(
            [
                'message' => 'success',
                'comment' => $comment,
            ]
        );


    }


    public function destroy(Comment $comment)
    {
        $comment_delete = Comment::find($comment->id);
        $comment_delete->delete();
        return response(
            [
                'message' => 'success',
                'status' => 200
            ]
        );

    }


}
