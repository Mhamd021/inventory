<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\PostCreatedNotification;
use Illuminate\Support\Facades\Notification;

class PostCreatedListener
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
    public function handle(PostCreated $event): void
    {
        $user = $event->post->user;
        $users = $user->friends;
        Notification::send($users, new PostCreatedNotification($event->post));
    }
}
