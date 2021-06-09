<?php

declare(strict_types=1);

namespace App\Mail;

use App\Organisation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganisationCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Organisation
     */
    protected $organisation;

    /**
     * @var User
     */
    protected $user;

    /**
     * OrganisationCreatedNotification constructor.
     * @param Organisation $organisation
     * @param User $user
     */
    public function __construct(Organisation $organisation, User $user)
    {
        $this->organisation = $organisation;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): Mailable
    {
        return $this->view('mail.organisation_created_notification', [
            'user' => $this->getUser(),
            'organisation' => $this->getOrganisation(),
        ]);
    }

    public function getOrganisation()
    {
        return $this->organisation;
    }

    public function getUser()
    {
        return $this->user;
    }
}
