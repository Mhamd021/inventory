<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Events\PostCreated;
use App\Http\Requests\PostRequest;
use App\Services\ImageService;

class PostController extends Controller
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
         $this->imageService = $imageService;
    }

    public function index()
    {
        $posts = Post::with('user:id,name')->get();
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


        $attributes = $request->all();
        $attributes['user_id'] = auth('sanctum')->user()->id;
        if ($request->hasFile('post_image')) {
            $attributes['post_image'] = $this->imageService->upload($request->post_image,'uploads/posts');
        }

        $post = Post::create($attributes);
        event(new PostCreated($post));

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


    public function show(Post $post)
    {

        $post = Post::with('user:id,name')->findorfail($post->id);
        return response()->json([
            'message' => "post retreived",
            'post' => $post,
            'status' => 200
        ]);
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
