<?php

namespace App\Mail;

use App\Organisation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganisationCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed
     */
    public $organisation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): OrganisationCreatedMail
    {
        return $this->text('emails.organisation-created-plain');
    }
}
