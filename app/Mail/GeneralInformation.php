<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GeneralInformation extends Mailable
{
    use Queueable, SerializesModels;
    
    public $message = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mes)
    {
        $this->message = $mes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.name') . 'からのお知らせ')
            ->markdown('emails.general.information');
    }
}
