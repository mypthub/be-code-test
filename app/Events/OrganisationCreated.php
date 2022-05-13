<?php

namespace App\Events;

use App\Organisation;

class OrganisationCreated
{
    /**
     * @var Organisation
     */
    private $organisation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * @return Organisation
     */
    public function getOrganisation(): Organisation
    {
        return $this->organisation;
    }
}
