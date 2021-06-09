<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Organisation\CreateOrganisationRequest;
use App\Organisation;
use App\Services\OrganisationServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * @param CreateOrganisationRequest $createOrganisationRequest
     * @param OrganisationServiceContract $service
     * @return JsonResponse
     */
    public function store(
        CreateOrganisationRequest $createOrganisationRequest,
        OrganisationServiceContract $service
    ): JsonResponse
    {
        /** @var Organisation $organisation */
        $organisation = $service->createOrganisation($createOrganisationRequest->validated());

        return $this
            ->transformItem('organisation', $organisation, ['user'])
            ->respond();
    }

    /**
     * @param Request $request
     * @param OrganisationServiceContract $service
     * @return JsonResponse
     */
    public function listAll(Request $request, OrganisationServiceContract $service): JsonResponse
    {
        return $this->transformCollection(
            'organisations',
            $data = $service->listAll($request),
            ['user']
        )->withPagination($data)->respond();
    }
}
