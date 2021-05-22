<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
use Carbon\Carbon;
use App\Mail\ConfirmEmail;
use Mail;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    /**
     * @param array $attributes
     *
     * @return Organisation
     */
    public function createOrganisation(array $attributes): Organisation
    {
        $organisation = new Organisation();

        if(!empty($attributes)){

            $organisation->name = $attributes['name'];
            $organisation->owner_user_id = $attributes['owner_user_id'];
            $organisation->trial_end = Carbon::now()->addMonth()->toDateTimeString();
            $organisation->subscribed = 0;
            $saved = $organisation->save();

            if($saved)
            {
                $emailParam['organization_name'] = $organisation->name;
                $emailParam['name'] = $organisation->owner->name;
                $emailParam['email'] = $organisation->owner->email;
                $emailParam['trial_end'] = Carbon::createFromFormat('Y-m-d H:i:s', $organisation->trial_end)->format('F d, Y');
                $emailParam['subject'] = 'Organisation registration successful';

                //$mail = Mail::to($organisation->owner->email)->send(new ConfirmEmail($emailParam)); 
            }

            
        }

        return $organisation;
    }
}
