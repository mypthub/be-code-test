<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
use App\User;
use Carbon\Carbon;

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
        if (array_key_exists('owner_user_id', $attributes)) {
            $user = User::find($attributes['owner_user_id']);
        } else {
            $user = auth()->user();
        }

        return $user->organisation()->create([
            'name' => $attributes['name'],
            'trial_end' => Carbon::now()->addDays(30)->toDateTimeString(),
        ]);
    }

    public function getFilteredOrganisations(array $attributes, bool $withPagination = true)
    {
        $organisations = Organisation::query()->with('owner:id,name,email');

        if (array_key_exists('filter', $attributes)) {

            if ($attributes['filter'] === 'subbed') {
                $organisations->isSubscribed();
            }

            if ($attributes['filter'] === 'trial') {
                $organisations->isSubscribed(false);
            }
        }
        return $withPagination ? $organisations->paginate() : $organisations->get();

    }
}
