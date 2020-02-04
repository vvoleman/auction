<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notification;

class SendUserCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $not = Notification::make([
            "type_id"=>3,
            "notification"=>"Vítej na naší stránce!",
            "url"=>"dodělej url"
        ]);
        $not->users()->attach($event->user->id_u);
        $not->save();
    }
}
