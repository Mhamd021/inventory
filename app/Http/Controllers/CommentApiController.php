<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Events\CommentOnPost;



class CommentApiController extends Controller
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
        try {
            $validated = $request->validate([
                'comment_info' => ['bail', 'required', 'string'],
                'post_id' => ['required', 'integer', 'exists:posts,id'],
            ]);

            $comment = Comment::create([
                'comment_info' => $request->comment_info,
                'user_id' => auth('sanctum')->user()->id,
                'post_id' => $request->post_id,
            ]);

            return response()->json([
                'message' => 'comment created successfully',
                'comment' => $comment,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment = Comment::with('user:id,name')->findorfail($comment->id);

        return response()->json([
            'comment' => $comment,
            'status' => 200,
        ]);
    }

    public function ModifyComment(Request $request, Comment $comment)
    {
        if ( auth('sanctum')->user()->id == $comment->user->id) {
            $validated = $request->validate([
                'comment_info' => ['bail', 'required', 'string'],
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
        } else {
            return response()->json(
                [
                    'message' => 'you are not authorized to modify this comment'
                ]
            );
        }
    }
    public function destroy(Comment $comment)
    {
        $comment_delete = Comment::find($comment->id);
        if (auth('sanctum')->user()->id == $comment_delete->user->id) {
            $comment_delete->delete();
            return response()->json(
                [
                    'message' => 'success',
                    'status' => 200
                ]
            );
        } else {
            return response()->json(['message' => 'you are not authorized to delete this comment']);
        }
    }
}
