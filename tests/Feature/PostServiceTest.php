<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\PostService;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_method_creates_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum'); 

        $request = new \App\Http\Requests\PostRequest([
            'post_info' => 'Test Post',
        ]);

        $postService = new PostService(new \App\Services\ImageService);
        $post = $postService->store($request);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Test Post', $post->title);
        $this->assertEquals($user->id, $post->user_id);
    }
}
