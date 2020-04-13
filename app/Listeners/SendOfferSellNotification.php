<?php

namespace App\Listeners;

use App\Events\NewNotification;
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

        $data = [
            "offer_name"=>$event->offersell->offer->name,
            "buyer_fullname"=>$event->offersell->buyer->fullname,
            "date"=>$event->offersell->created_at
        ];
        //Mail::to($event->offersell->offer->owner->email)->send(new \App\Mail\OfferSellCreatedOwner($data));
        //Mail::to($event->offersell->buyer->email)->send(new \App\Mail\OfferSellCreatedBuyer($data));
        event(new NewNotification($event->offersell->offer->owner,[
            "type_id"=>1,
            "notification"=>'Nová žádost o koupi "'.$event->offersell->offer->name.'"!',

            "url"=>route('offers.confirm',['id'=>$event->offersell->offer->uuid,"os_id"=>$event->offersell->id_os])
        ]));
    }
}
