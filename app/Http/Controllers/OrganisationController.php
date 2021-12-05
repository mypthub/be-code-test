<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Organisation;
use App\Mail\NewOrganisation;
use App\Services\OrganisationService;
use App\Transformers\OrganisationTransformer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    public function listAll(OrganisationService $service)
    {
        $filter = $_GET['filter'] ?? false;
        $query = new Organisation;

        switch ($filter) {
            case 'subbed':
                $query = $query->where('subscribed', 1);
                break;
            case 'trial':
                $query = $query->where('subscribed', 0);
                break;
            default:
                break;
        }
        $organisations = $query->get();

        return $this->transformCollection('organisation', $organisations, ['user'])->respond();
    }

    /**
     *
     * @return response
     */
    public function create(): JsonResponse
    {
        /**
         * caveat - currently you will get redirected if you don't add the header `Accept: application/json`
         */
        $this->request->validate(array_merge(Organisation::$rules, []));

        $data = $this->request->all();

        $user = auth()->user();

        /**
         * here i've made the assumption the user is the person currently logged in
         */
        $organisationData = [
            'owner_user_id' => $user['id'],
            'name' => $data['name'],
            'subscribed' => $data['subscribed'],
        ];
        $organisation = Organisation::firstOrNew($organisationData);

        //create end date
        $organisation->trial_end = Carbon::now()->addDays(30)->toDateTimeString();

        /**
         * If we can save the organisation then lets send an email
         */
        if ($organisation->save()) {
            $emailRecipient = $user->email;

            $send = Mail::to($emailRecipient)->send(new NewOrganisation($organisation));

            return $this->transformItem('organisation', $organisation, ['user'])->respond();
        }

        /**
         * `418 I'm a Teapot` - should likely be a 400 or 500 error, leaving in to improve your day.
         */
        return response()->json([
            'message' => 'unable to create organisation', 
            'data' => $organisationData,
        ], 418);
    }
}
