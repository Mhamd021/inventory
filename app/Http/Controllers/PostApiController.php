<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Events\PostCreated;
use App\Http\Requests\PostRequest;
use App\Services\ImageService;
use App\Services\PostService;
use Illuminate\Support\Facades\Request;

class PostApiController extends Controller
{

    protected $imageService;
    protected $postService;

    public function __construct(ImageService $imageService, PostService $postService)
    {
         $this->imageService = $imageService;
         $this->postService = $postService;
    }
    public function getComments(Post $post)
    {
        $comments = $this->postService->getComments($post);
        return response()->json([
            'comments' => $comments
        ]);
    }

    public function getCommentCount(Post $post)
    {
        $count = $this->postService->getCommentCount($post);
        return response()->json([
            'count' => $count
        ]);
    }

    public function getLikesCount(Post $post)
    {
        $likes = $this->postService->getLikesCount($post);
        return response()->json([
            'likecount' => $likes
        ]);
    }

    public function index()
    {
        $posts = Post::with('user:id,name,user_image')
                    ->latest()
                    ->get()
                    ->map(function ($post) {
                        return $post->customToArray();
                    });

        return response()->stream(
            function () use ($posts) {
                echo json_encode(['posts' => $posts]);
            },
            200,
            ['Content-Type' => 'application/json']
        );
    }
    
    public function store(PostRequest $request)
    {
        $post = $this->postService->store($request);
        return response()->json(
            [
                'message' => 'created successfully!',
                'post' => $post->customToArray(),
                'status' => 200,
            ]
        );
    }

    public function ModifyPost(PostRequest $request, Post $post)
    {

        if (auth('sanctum')->user()->id == $post->user->id)
        {

            if ($request->hasFile('post_image')) {

                if ($post->post_image && file_exists($post->post_image))
                 {
                    $this->imageService->delete($post->post_image);
                 }

                $post->post_image = $this->imageService->upload($request->post_image,'uploads/posts');
            }

            $post->post_info = $request->post_info;
            $post->save();
            // $post->makeHidden(['user']);

            return response()->json(
                [
                    'message' => 'updated successfully!',
                    'post' => $post->customToArray(),
                    'status' => 200,
                ]
            );
        } else {
            return response()->json([ 'message' => 'You are not authorized to modify this post', ], 403);
        }
    }


    public function show(Request $request,Post $post)
    {

        $post = Post::with('user:id,name')->findorfail($post->id);
        if ($request->expectsJson())
        {
            return response()->json([
                'message' => "post retreived",
                'post' => $post,
                'status' => 200
            ]);
        }
        else
        {

        }

    }

    public function destroy(Post $post)
    {
        $post_delete = Post::find($post->id);
        if (auth('sanctum')->user()->id == $post_delete->user_id) {
        $post_delete->delete();
        return response()->json(
            [
                'message' => 'success! the post is deleted',
                'status' => 200
            ]
        );
        } else {
            return response()->json([
                'messages' => 'you are not authorized to delete this post',
            ]);
        }
    }
}
