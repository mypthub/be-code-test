<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Transformers\OrganisationTransformer;

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
        $auth = App::make(Auth::class);
        $organisation = new Organisation();
        
        // $organisation->create($attributes);

        //save organisation
        $organisation->name = $attributes['name'];
        $organisation->owner_user_id = $auth::id();
        $organisation->trial_end = Carbon::now()->add('day', 30);
        $organisation->save();

        //send email
        $mailData['user'] = $auth::user()->name;
        $mailData['organisation'] = $organisation->name;
        $mailData['trial_end'] = (string)$organisation->trial_end;

        Mail::to($auth::user()->email)->send(new SendMail($mailData));

        return $organisation;
    }

    /**
     * @param string $filter
     *
     * @return Organisations
     */
    public function getOrganisations($filter = null)
    {
        $organisation = new Organisation();

        if ($filter === 'all' || !$filter) {
            $Organisations = $organisation->all();
        } else {
            if ($filter == 'subbed') {
                $status = 1;
            } elseif ($filter == 'trial') {
                $status = 0;
            } else {
                throw new \Exception('Filter param imvalid');
            }

            $Organisations = $organisation->where('subscribed', '=', $status)->get();
        }

        return $Organisations;
    }
}
