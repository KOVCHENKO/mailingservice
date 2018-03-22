<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($description)
    {
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notification')
            ->with([
                'description' => $this->description
            ]);
    }
}
