<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Organisation;
use App\Services\OrganisationService;
use App\Services\ListOrganisation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Validator;


/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function store(OrganisationService $service): JsonResponse
    {

        $formInput = $this->request->all();

        $validator = Validator::make($formInput, [
            'name' => 'required|unique:organisations,name',
            'owner_user_id' => 'required|numeric'
        ],
        [
            'name.required' => 'Please enter organisation name',
            'owner_user_id.required' => 'Please enter owner user id',
            'owner_user_id.numeric' => 'Owner user id must be a number.'
        ],);

        if ($validator->fails())
        {
            $errors[] = $validator->errors();
            return response()->json(["errors" => $errors]);
        }

        /** @var Organisation $organisation */
        $organisation = $service->createOrganisation($this->request->all());

        return $this
            ->transformItem('organisation', $organisation, ['user'])
            ->respond();
    }

    /**
     * @param ListOrganisation $list
     *
     * @return JsonResponse
     */
    public function listAll(ListOrganisation $list)
    {
        $filter = $_GET['filter'];
        if(isset($filter))
        {
            $listOrganisation = $list->listOrganisation($filter);
        }
        return $this
            ->transformCollection('organisation', $listOrganisation, ['user'])
            ->respond();
    }


}
