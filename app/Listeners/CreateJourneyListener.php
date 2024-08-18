<?php

namespace App\Listeners;

use App\Events\CreateJourney;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Journey;
use App\Models\User;
use App\Notifications\JourneyCreatedNotification ;
use Illuminate\Support\Facades\Notification;

class CreateJourneyListener
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
    public function handle(CreateJourney $event)
    {

        $users = User::where('is_admin',0)->get();
        Notification::send($users, new JourneyCreatedNotification($event->journey));



    }
}
