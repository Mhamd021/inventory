<?php

namespace App\Listeners;

use App\Events\EditJourney;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Journey;
use App\Models\User;
use App\Notifications\JourneyEdited ;
use Illuminate\Support\Facades\Notification;

class EditJourneyListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(EditJourney $event): void
    {
        $users = User::where('is_admin',0)->get();
        Notification::send($users, new JourneyEdited($event->journey));
    }
}
