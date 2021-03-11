<?php

namespace App\Listeners;

use App\Events\OrgnisationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\OrganisationWelcomeEmail;

class SendWelcomeEmail{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Handle the event.
     *
     * @param  OrgnisationCreated  $event
     * @return void
     */
    public function handle(OrgnisationCreated $event){
        \Mail::to($event->user->email)->send(
            new OrganisationWelcomeEmail($event->user,$event->organisation)
        );
    }
}
