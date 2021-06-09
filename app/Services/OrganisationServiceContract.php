<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface OrganisationServiceContract
{
    /**
     * @param array $attributes
     * @return Organisation
     */
    public function createOrganisation(array $attributes): Organisation;

    /**
     * @param Request $request
     * @return Collection
     */
    public function listAll(Request $request): Collection;
}
