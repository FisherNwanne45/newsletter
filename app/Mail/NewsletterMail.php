<?php

namespace App\Mail;

use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter;
    public $subscriber;

    /**
     * Create a new message instance.
     */
    public function __construct(Newsletter $newsletter, Subscriber $subscriber)
    {
        $this->newsletter = $newsletter;
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.newsletter')
                    ->subject($this->newsletter->title)
                    ->with([
                        'content' => $this->newsletter->content,
                        'subscriberName' => $this->subscriber->name,
                    ]);
    }
}