<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(10);
        return  PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

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
         return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
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
                'message' => 'success',
                'status' => 200
            ]
        );
    }
}