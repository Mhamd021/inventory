<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Auth;
use App\Events\PostCreated;
use App\Http\Resources\Post as PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{



    public function index()
    {

        $posts = Post::with('user:id,name')->get();
        // $posts = Post::withCount(['likes as liked' => function ($query) use ($user_id)
        // {
        //     $query->where('user_id',$user_id);
        // }])->get();

        // $posts->transform(function($post)
        // {
        //     $post->liked = $post->liked > 0 ;
        //     return $post;
        // });



        if ($posts->count() != 0) {
            return response()->json(
                [

                    "message" => "success",
                    "posts" => $posts,
                    "status" => 200,
                ]
            );
        } else {
            return response()->json([
                "message" => "there are no posts please create one!",

            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'post_info' => ['required'],
            'post_image' => ['file', 'nullable']
        ]);

        $attributes = $request->all();
        $attributes['user_id'] = auth('sanctum')->user()->id;
        if ($request->hasFile('post_image')) {
            $image = $request->post_image;
            $newImage = time() . $image->getClientOriginalName();
            $image->move('uploads/posts', $newImage);
            $attributes['post_image'] = 'uploads/posts/' . $newImage;
        }
        $post = Post::create($attributes);
        event(new PostCreated($post));
        return response()->json(
            [
                'message' => 'created successfully!',
                'post' => $post,
                'status' => 200
            ]
        );
    }
    public function ModifyPost(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [

            'post_info' => ['required'],

        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                403
            );
        }
        if ($request->hasFile('post_image')) {
            $image = $request->post_image;
            $newImage = time() . $image->getClientOriginalName();
            $image->move('uploads/posts/', $newImage);
            $post->post_image = 'uploads/posts/' . $newImage;
        }

        $post->post_info = $request->post_info;
        $post->save();
        return response()->json(
            [
                'message' => 'updated successfully!',
                'post' => $post,
                'status' => 200,
            ]
        );
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
        $post_delete->delete();
        return response()->json(
            [
                'message' => 'success! the post is deleted',
                'status' => 200
            ]
        );
    }
}
