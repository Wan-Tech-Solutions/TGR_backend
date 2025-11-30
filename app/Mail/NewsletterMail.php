<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $bodyContent;
    public $unsubscribeToken;
    // use a unique name to avoid collision with Mailable internals
    public $attachmentPaths = [];
    // avoid overriding Mailable::$replyTo (array) — use a different name
    public $replyToAddress = null;

    /**
     * @param string $subjectLine
     * @param string $bodyContent
     * @param string|null $unsubscribeToken
     * @param array $attachments  Array of storage paths (relative to storage/app)
     * @param string|null $replyTo
     */
    public function __construct(string $subjectLine, string $bodyContent, ?string $unsubscribeToken = null, array $attachments = [], ?string $replyTo = null)
    {
        $this->subjectLine = $subjectLine;
        $this->bodyContent = $bodyContent;
        $this->unsubscribeToken = $unsubscribeToken;
        $this->attachmentPaths = $attachments;
        $this->replyToAddress = $replyTo;
    }

    public function build()
    {
        $m = $this->subject($this->subjectLine)
                  ->view('emails.newsletter')
                  ->with([
                      'bodyContent' => $this->bodyContent,
                      'unsubscribeToken' => $this->unsubscribeToken,
                  ]);

        if ($this->replyToAddress) {
            $m->replyTo($this->replyToAddress);
        }

        // Attach any stored files (paths are relative to storage/app)
        foreach ($this->attachmentPaths as $path) {
            $full = storage_path('app/' . $path);
            if (file_exists($full)) {
                $m->attach($full);
            }
        }

        return $m;
    }
}
