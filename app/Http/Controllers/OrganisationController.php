<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\OrganisationCreatedMail;
use App\Services\OrganisationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * @var OrganisationService
     */
    protected OrganisationService $organisationService;

    /**
     * @param OrganisationService $organisationService
     * @param Request $request
     */
    public function __construct(OrganisationService $organisationService, Request $request)
    {
        parent::__construct($request);
        $this->organisationService = $organisationService;
    }

    /**
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        $validator = Validator::make($this->request->all(), [
                'name' => 'required|unique:organisations,name|max:255',
                'owner_user_id' => 'sometimes|required|exists:users,id'
            ]
        // we can pass the second array to return custom error messages
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Create organisation
        $organisation = $this->organisationService->createOrganisation($validator->validated());

        // Trigger plain text mail
        Mail::to(auth()->user())->send(new OrganisationCreatedMail($organisation));

        return $this
            ->transformItem('organisation', $organisation, ['owner'])
            ->respond();
    }

    public function index(): JsonResponse
    {
        // Fetch the organisations (filter is available in query params)
        $organisations = $this->organisationService->getFilteredOrganisations($this->request->all());
        return $this
            ->transformCollection('organisations', $organisations, ['owner'])
            ->withPagination($organisations)
            ->respond();
    }
}
