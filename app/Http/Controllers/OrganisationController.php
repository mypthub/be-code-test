<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Organisation;
use App\Services\OrganisationService;
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
        $errors = [];
        //$data = [];
        //$message = 'Fill all required data.';
        $status = false;

        $inputData = $this->request->all();

        /** Validate input. */
        $validator = Validator::make($inputData, [
            'name' => 'required|unique:organisations,name',
            'owner_user_id' => 'required|numeric'
        ],
            [
                'name.required' => 'Organisation name is required field.',
                'owner_user_id.required' => 'Organisation owner id is required field.',
                'owner_user_id.numeric' => 'Organisation owner id must be a number.'
            ], );

        if ($validator->fails())
        {
            $errors[] = $validator->errors();
        }
        else
        {
            try {
                /** @var Organisation $organisation */
                $organisation = $service->createOrganisation($this->request->all());

                return $this
                    ->transformItem('organisation', $organisation, ['user'])
                    ->respond();
            } catch (\Exception $e) {
                //$message = 'Oops! Something went wrong on server.';
                $errors[] = [
                    "error" => $e->getMessage(),
                ];
            }
        }

        return response()->json(["status" => $status, "errors" => $errors]);
    }

    /**
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function listAll(OrganisationService $service): JsonResponse
    {
        $inputData = $this->request->all();
        $errors = [];        
        $status = false;
        
        try {
            /** If filter param is not sent set deafult to all */
            $filter = !empty($inputData['filter']) ? $inputData['filter'] : 'all';
            $organisations = $service->listOrganisations($filter);
            return $this
                ->transformCollection('organisations', $organisations)
                ->respond();
        } catch (\Exception $e) {
            //$message = 'Oops! Something went wrong on server.';
            $errors[] = [
                "error" => $e->getMessage(),
            ];
        }

        return response()->json(["status" => $status, "errors" => $errors]);
    }
}
