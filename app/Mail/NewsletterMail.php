<?php

namespace App\Mail;

use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter;
    public $subscriber;
    public $attachmentFile; // To handle the file directly

    /**
     * Create a new message instance.
     */
    public function __construct(Newsletter $newsletter, Subscriber $subscriber, $attachmentFile = null)
    {
        $this->newsletter = $newsletter;
        $this->subscriber = $subscriber;
        $this->attachmentFile = $attachmentFile; // Store the attachment file
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $email = $this->view('emails.newsletter')
                      ->subject($this->newsletter->title)
                      ->with([
                          'content' => $this->newsletter->content,
                          'subscriberName' => $this->subscriber->name,
                      ]);

        // If an attachment is provided, attach it directly without saving it
        if ($this->attachmentFile) {
            $email->attachData(
                file_get_contents($this->attachmentFile->getRealPath()), // Get file contents directly
                $this->attachmentFile->getClientOriginalName(),         // File's original name
                [
                    'mime' => $this->attachmentFile->getMimeType()       // Correct MIME type for the file
                ]
            );
        }

        return $email;
    }
}