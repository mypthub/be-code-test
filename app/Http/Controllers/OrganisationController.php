<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrganisationCreateRequest;
use App\Http\Requests\OrganisationFilterRequest;
use App\Services\OrganisationFilterData;
use App\Services\OrganisationService;
use Illuminate\Http\JsonResponse;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * @param OrganisationCreateRequest $request
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function store(OrganisationCreateRequest $request, OrganisationService $service): JsonResponse
    {
        $organisation = $service->createOrganisation($request->input('name'), $request->user());

        return $this
            ->transformItem('organisation', $organisation, ['user'])
            ->respond();
    }

    /**
     * @param OrganisationFilterRequest $request
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function listAll(OrganisationFilterRequest $request, OrganisationService $service)
    {
        $data = new OrganisationFilterData();
        $data->setFilter($request->input('filter', OrganisationFilterData::FILTER_DEFAULT));

        $collection = $service->getList($data);

        return $this
            ->transformCollection('organisations', $collection)
            ->respond();
    }
}
