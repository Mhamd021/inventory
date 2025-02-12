<?php

namespace App\Services;

use App\Events\PostCreated;
use App\Http\Requests\PostRequest;
use App\Models\Post;

class PostService
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
         $this->imageService = $imageService;
    }
   public function store(PostRequest $request) : Post
   {
    $attributes = $request->all();
        $attributes['user_id'] = auth('sanctum')->user()->id;
        if ($request->hasFile('post_image')) {
            $attributes['post_image'] = $this->imageService->upload($request->post_image,'uploads/posts');
        }
        $post = Post::create($attributes);
        event(new PostCreated($post));
        return $post;
   }

   public function getComments(Post $post)
   {
       return $post->comments;
   }

   public function getCommentCount(Post $post)
   {
       return $post->comments_count;

   }

   public function getLikesCount(Post $post)
   {
       return  $post->likes_count;
   }

}
