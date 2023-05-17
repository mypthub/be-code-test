<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
use App\Services\EmailServices;
use Carbon\Carbon;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{

    public function __construct(){
      $this->EmailServices = new EmailServices();
    }

    /**
     * @param array $attributes
     *
     * @return Organisation
     */
    public function createOrganisation(array $attributes): Organisation
    {
        $organisation = new Organisation();
        $organisation->name  =  $attributes['name'];
        $organisation->owner_user_id  =  $attributes['owner_user_id'];
        $organisation->trial_end  =  \Carbon\Carbon::now()->addDays(30);
        $organisation->subscribed  =  true;
        $organisation->save();
        $this->EmailServices->sendEmail($organisation->id);
        return $organisation;
    }
}
