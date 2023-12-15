<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $quotation;
    public $quotation_items;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$quotation,$quotation_items)
    {
        $this->user = $user;
        $this->quotation = $quotation;
        $this->quotation_items = $quotation_items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Email.quotationEmail')->subject('Quotation Email!')->with([
            'user' => $this->user,
            'quotation' => $this->quotation,
            'quotation_items' => $this->quotation_items,
        ]);
    }
}
