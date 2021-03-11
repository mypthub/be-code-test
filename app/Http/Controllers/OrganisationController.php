<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\OrgnisationCreated;
use App\Organisation;
use App\Services\OrganisationService;
use App\Transformers\OrganisationTransformer;
use Illuminate\Http\JsonResponse;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @var OrganisationTransformer
     */
    private $organisationTransformer;

    function __construct(Manager $fractal, OrganisationTransformer $organisationTransformer)
    {
        $this->fractal = $fractal;
        $this->organisationTransformer = $organisationTransformer;
    }

    /**
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function store(Request $request, OrganisationService $service): JsonResponse{
        $response = array("status"=>false,"data"=>"","error"=>"","message"=>"Something went wrong!");
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:8|max:255',
            'subscribed' => 'required',
        ]);

        if ($validator->fails()) {
            $response = array("status"=>false,"data"=>"","error"=>$validator->errors(),"message"=>"Please check with validation error.");
        }else{
            if (Auth::check()) {

                /** @var Organisation $organisation */
                $organisation = $service->createOrganisation($request->all());
                event(new OrgnisationCreated(Auth::user(),$organisation));

                return $this
                ->transformItem('organisation', $organisation, ['user'])
                ->respond();
            }else{
                $response = array("status"=>false,"data"=>"","error"=>"","message"=>"You are not authenticated.");
            }
        }
        return response()->json($response);

    }

    /**
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function listAll(Request $request,OrganisationService $service){
        $filter = $request->query('filter') ?: false;
        $organisationList = Organisation::all();
        $organisation = $service->filterOrgnization(collect($organisationList),$filter);
        $organisation = new Collection($organisation, $this->organisationTransformer); // Create a resource collection transformer
        $this->fractal->parseIncludes('user'); // parse includes
        return $organisation = $this->fractal->createData($organisation)->toJson(); // Transform data
    }

}
