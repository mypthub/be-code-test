<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;

use App\Mail\OwnerConfirmation;
use Carbon\Carbon;
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
        try {
            $organisation = new Organisation();
            $organisation->name = $attributes['name'];
            $organisation->owner_user_id = $attributes['owner_user_id'];
            $organisation->trial_end = Carbon::now()->addDay(config('constants.TRIAL_PERIOD'))->toDateTimeString();
            //$organisation->subscribed = !empty($attributes['subscribed']) ? $attributes['subscribed'] : 0;
            $organisation->save();

            $emailData['name'] = $organisation->owner->name;
            $emailData['email'] = $organisation->owner->email;
            $emailData['organization_name'] = $organisation->name;
            $emailData['trial_end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $organisation->trial_end)->format('F d, Y');
            $emailData['subject'] = 'Organisation registration - ' . $organisation->name;
            
            $mail = Mail::to($organisation->owner->email)->send(new OwnerConfirmation($emailData));

        } catch (Throwable $e) {
            report($e);
            return false;
        }

        return $organisation;
    }

    /**
     * @param string $param
     *
     * @return object
     */
    public function listOrganisations(string $param): object 
    {
        try {
            $modelQuery = new Organisation();
            if (!empty($param))
            {
                if ($param === 'subbed')
                {
                    $modelQuery = $modelQuery
                                  ->where('subscribed', 1);
                } elseif ($param === 'trail')
                {
                    $modelQuery = $modelQuery
                        ->where('subscribed', 0);
                }
            }
            $organisations = $modelQuery->get();
        } catch (Throwable $e) {
            report($e);
            return false;
        }

        return $organisations;
    }
}
