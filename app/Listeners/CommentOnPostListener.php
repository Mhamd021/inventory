<?php

namespace App\Listeners;

use App\Events\CommentOnPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CommentOnPostNotification;
use App\Models\Post;
use App\Models\User;


class CommentOnPostListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentOnPost $event): void
    {
        $post = Post::find($event->comment->post_id);
        $user = User::find($post->user);
        Notification::send($user, new CommentOnPostNotification($event->comment));
    }
}
