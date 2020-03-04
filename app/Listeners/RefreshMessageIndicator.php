<?php

namespace App\Listeners;

use App\Events\ChangeIndicator;
use App\Events\NewMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Illuminate\Support\Facades\Auth;

class RefreshMessageIndicator
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
    public function handle(NewMessage $event)
    {
        if(Auth::check()){
            $user = User::where('uuid',$event->conversation_id)->firstOrFail();
            $msgs = $user->unread_conversations();

            event(new ChangeIndicator($msgs,$event->conversation_id));
        }
    }
}
