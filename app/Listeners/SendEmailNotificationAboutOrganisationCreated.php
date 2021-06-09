<?php

namespace App\Listeners;

use App\Events\OrganisationCreated;
use App\Mail\OrganisationCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationAboutOrganisationCreated
{

    /**
     * Handle the event.
     *
     * @param OrganisationCreated $event
     * @return void
     */
    public function handle(OrganisationCreated $event)
    {
        Mail::to($event->getUser()->email)->send(new OrganisationCreatedNotification(
            $event->getOrganisation(),
            $event->getUser()
        ));
    }
}
