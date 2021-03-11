<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganisationWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var object
     */
    public $user;

    /**
     * @var object
     */
    public $organisation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$organisation)
    {
        $this->user = $user;
        $this->organisation = $organisation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome_email');
    }
}
