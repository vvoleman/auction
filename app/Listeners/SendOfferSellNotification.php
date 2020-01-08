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

        $data = [
            "offer_name"=>$event->offersell->offer->name,
            "buyer_fullname"=>$event->offersell->buyer->fullname,
            "date"=>$event->offersell->created_at->format("d. m. y H:i")
        ];
        Mail::to($event->offersell->offer->owner->email)->send(new \App\Mail\OfferSellCreatedOwner($data));
        Mail::to($event->offersell->buyer->email)->send(new \App\Mail\OfferSellCreatedBuyer($data));
        $n = Notification::create([
            "type_id"=>1,
            "notification"=>'Nová žádost o koupi "'.$event->offersell->offer->name.'"!',
            "url"=>"dodelej url"
        ]);
        $n->users()->attach($event->offersell->offer->owner->id_u);
        $n->save();
    }
}
