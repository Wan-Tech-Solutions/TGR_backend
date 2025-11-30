<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnsubscribeRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Confirm Unsubscribe')
                    ->view('emails.unsubscribe_request')
                    ->with(['token' => $this->token]);
    }
}
