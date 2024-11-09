<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Events\CommentOnPost;
use App\Http\Resources\Comment as CommentResource;

class CommentController extends Controller
{

    public function postcomments(Post $post)
    {

        $post = Post::findorfail($post->id);
        $comments = $post->comments;
            return response()->json([

                "count" => $comments->count()
            ]);



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

        return response()->json([
            'message' => 'comment created successfully',
            'comment' => $comment
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment = Comment::with('user:id,name')->findorfail($comment->id);

            return response()->json([
                'comment' => $comment,
                'status' => 200 ,
            ]);



    }

    public function ModifyComment(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'comment_info' => ['bail','required','string'],
        ]);
        $comment->comment_info = $request->comment_info;
        $comment->save();
        return response()->json(
            [
                'message' => 'success',
                'comment' => $comment,
                'status' => 200
            ]
        );

    }


    public function destroy(Comment $comment)
    {
        $comment_delete = Comment::find($comment->id);
        $comment_delete->delete();
        return response()->json(
            [
                'message' => 'success',
                'status' => 200
            ]
        );

    }


}
