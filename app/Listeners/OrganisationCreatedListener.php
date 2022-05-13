<?php

namespace App\Listeners;

use App\Events\OrganisationCreated;
use App\Notifications\OrganisationCreatedNotification;

class OrganisationCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  OrganisationCreated  $event
     * @return void
     */
    public function handle(OrganisationCreated $event)
    {
        $event->getOrganisation()
            ->owner
            ->notify(new OrganisationCreatedNotification($event->getOrganisation()));
    }
}
