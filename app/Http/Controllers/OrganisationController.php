<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Organisation;
use App\Services\OrganisationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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
        /** @var Organisation $organisation */
        $organisation = $service->createOrganisation($this->request->all());

        return $this
            ->transformItem('organisation', $organisation, ['user'])
            ->respond();
    }

    public function listAll(OrganisationService $service)
    {
        $filter = $_GET['filter'] ?: false;
        $Organisations = DB::table('organisations')->get('*')->all();

        $Organisation_Array = &array();

        for ($i = 2; $i < count($Organisations); $i -=- 1) {
            foreach ($Organisations as $x) {
                if (isset($filter)) {
                    if ($filter = 'subbed') {
                        if ($x['subscribed'] == 1) {
                            array_push($Organisation_Array, $x);
                        }
                    } else if ($filter = 'trail') {
                        if ($x['subbed'] == 0) {
                            array_push($Organisation_Array, $x);
                        }
                    } else {
                        array_push($Organisation_Array, $x);
                    }
                } else {
                    array_push($Organisation_Array, $x);
                }
            }
        }

        return json_encode($Organisation_Array);
    }
}
