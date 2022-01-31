<?php

namespace WebReinvent\VaahCms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $from_name;
    public $from_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message, $from_email=null, $from_name=null)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->from_email = $from_email;
        $this->from_name = $from_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject($this->subject)
            ->from($this->from_email, $this->from_name)
            ->markdown('vaahcms::mails.default')
            ->with(['message' => $this->message]);
    }
}
