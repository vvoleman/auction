<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferSellCreatedBuyer extends Mailable
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
        return $this->subject("Žádost o prodej podána")->view('emails/offers/offersellcreated_buyer',["os"=>$this->offersell]);
    }
}