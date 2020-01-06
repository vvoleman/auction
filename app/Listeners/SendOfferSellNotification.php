<?php

namespace App\Listeners;

use App\Events\OfferSellCreated;
use App\Mail\OfferSellCreatedOwner;
use App\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOfferSellNotification
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
     * @param  OfferSellCreated  $event
     * @return void
     */
    public function handle(OfferSellCreated $event)
    {
        //zpráva pro kupujícího
            //email?
        //zpráva pro prodávajícího
            //email?
            //notifikace v db
        Mail::to($event->offersell->offer->owner->email)->queue(new \App\Mail\OfferSellCreatedOwner($event->offersell));
        Mail::to($event->offersell->buyer->email)->queue(new \App\Mail\OfferSellCreatedBuyer($event->offersell));
        $n = Notification::create([
            "type_id"=>1,
            "notification"=>'Nová žádost o koupi "'.$event->offersell->offer->name.'"!',
            "url"=>"dodelej url"
        ]);
        $n->users()->attach($event->offersell->offer->owner->id_u);
        $n->save();
    }
}
