<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Transformers\OrganisationTransformer;

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
        $auth = App::make(Auth::class);
        $organisation = new Organisation();
        
        // $organisation->create($attributes);

        $organisation->name = $attributes['name'];
        $organisation->owner_user_id = $auth::id();
        $organisation->trial_end = Carbon::now()->add('day', 30);

        $organisation->save();
        
        return $organisation;
    }
}
