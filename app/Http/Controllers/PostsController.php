<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\ImageService;
use App\Services\PostService;

class PostsController extends Controller
{
    protected $imageService;
    protected $postService;
    public function __construct(ImageService $imageService , PostService $postService)
    {
         $this->imageService = $imageService;
         $this->postService = $postService;
    }



    public function getComments(Post $post)
    {
        $comments = $this->postService->getComments($post);
        return response()->json($comments);
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
        $posts = Post::with('user:id,name,user_image')->latest()->get();
        return view('posts.index',compact('posts'));
    }


    public function create()
    {
        return view('posts.create');
    }


    public function store(PostRequest $request)
    {
        $post = $this->postService->store($request);
        return redirect()->back()->with('success','Post Created');
    }

    public function show(Post $post)
    {
        return view('posts.show',$post->with('user:id,name'));
    }

    public function edit(PostRequest $request , Post $post)
    {
        return view('posts.edit',compact('post'));
    }


    public function update(PostRequest $request, Post $post)
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

          return redirect()->back()->with('success','Post have been edited');
        } else {
            return redirect()->back()->withErrors('UnAuthorized','You cant modify this post');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (auth('sanctum')->user()->id == $post->user_id) {
        $post->delete();
        return redirect()->route('posts.index')->with('Post Deleted','The Post Have Been Deleted');
        } else {
            return redirect()->back()->withErrors('UnAuthorized','You cant delete this post');
        }
    }
}
