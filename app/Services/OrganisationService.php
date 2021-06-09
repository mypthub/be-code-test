<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
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
        return auth()->user()
            ->organisations()
            ->create(array_merge($attributes, [
                'trial_end' => Carbon::now()->addDays(30),
            ]));
    }
}
