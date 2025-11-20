<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $attachment;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $message, $attachment = null)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $email = $this->subject($this->subject)
                      ->view('adminPortal.email.template')
                      ->with([
                          'messageContent' => $this->message, // Pass it as a variable
                      ]);

        // Attach file if present
        if ($this->attachment) {
            $email->attach(storage_path("app/public/" . $this->attachment));
        }

        return $email;
    }
}
