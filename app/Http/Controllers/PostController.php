<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Auth;
use App\Events\PostCreated;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        if($posts)
        {
            $api_posts = PostResource::collection($posts);

            return response
            (
                [
                    "message" => "success" ,
                    "post" => $api_posts,
                    "status" => 200,
                ]
                );
        }
        else
        {
            return response ([
                "message" => "there are no posts please create one!" ,
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'user_id' => ['required'],
            'post_info' => ['required'],

        ]);

            $attributes = $request->all();

        if($request->hasFile('post_image'))
        {
       $image = $request->post_image;
       $newImage = time().$image->getClientOriginalName();
       $image->move('uploads/posts',$newImage);
        $attributes['post_image'] = 'uploads/posts'.$newImage;
        }

        $post = Post::create($attributes);

        event(new PostCreated($post));
        // foreach($validator as $validate)
        // {
        //     if($validate->falis())
        //     {
        //         return response()->json([
        //             "message" => $validate->message(),
        //         ]);
        //     }
        // }
         return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response ([
            'message' => "post retreived" ,
            'post' => new PostResource($post),
            'status' => 200
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $validated = $request->validate([
            'post_info' => ['required'],

        ]);

        $post = Post::find($request->id);

        if($request->hasFile('post_image'))
        {
       $image = $request->post_image;
       $newImage = time().$image->getClientOriginalName();
       $image->move('uploads/posts',$newImage);
       $post->post_image = 'uploads/posts/'.$newImage;
        }

            $post->post_info = $request->post_info;

            $post->save();

           return response
           (
            [
                'message' => 'success',
                'post' => $post,
                'status' => 200,
            ]
           );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {

        $post_delete = Post::find($post->id);
        $post_delete->delete();
        return response(
            [
                'message' => 'success! the post is deleted',
                'status' => 200
            ]
        );
    }
}
