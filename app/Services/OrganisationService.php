<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
        //dd($attributes);
        $organisation = new Organisation();
        $organisation->name = $attributes['name'];
        $organisation->owner_user_id = Auth::user()->id;
        $organisation->subscribed = $attributes['subscribed'];
        $organisation->trial_end = !$attributes['subscribed'] ? Carbon::now()->addDays(30) : null;
        $organisation->save();

        return $organisation;
    }

    /**
     * @param collection $attributes
     * @param string $filter
     *
     * @return Organisation
     */
    public function filterOrgnization(Collection $organisationCollection,string $filter): Collection{

        if (isset($filter)) {
            if ($filter == 'subbed') {
                $organisationCollection->transform(function ($item, $key) {
                    if ($item->subscribed == 1) {
                        return $item;
                    }
                });
            } else if ($filter == 'trial') {
                $organisationCollection->transform(function ($item, $key) {
                    if ($item->subscribed == 0) {
                        return $item;
                    }
                });
            }
        }
        $organisationCollection = $organisationCollection->filter(function ($item, $key) {
            return $item != null;
        });

        return $organisationCollection;
    }
}
