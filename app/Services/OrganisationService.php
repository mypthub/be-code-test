<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\OrganisationCreated;
use App\Organisation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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
        $record = auth()->user()
            ->organisations()
            ->create(array_merge($attributes, [
                'trial_end' => Carbon::now()->addDays(30),
            ]));

        event(new OrganisationCreated($record, auth()->user()));

        return $record;
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function listAll(Request $request): Collection
    {
        return Organisation::filter($request->get('filter', 'all'))
            ->get();
    }
}
