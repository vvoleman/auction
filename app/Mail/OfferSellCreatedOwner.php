<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferSellCreatedOwner extends Mailable
{
    use Queueable, SerializesModels;

    private $offersell;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($offersell)
    {
        $this->offersell = $offersell;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Nová žádost o koupi")->view('emails/offers/offersellcreated_owner',["os"=>$this->offersell]);
    }
}
