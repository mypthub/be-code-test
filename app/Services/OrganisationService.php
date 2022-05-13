<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\OrganisationCreated;
use App\Organisation;
use App\User;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    /**
     * @param string $name
     * @param User $user
     * @return Organisation
     */
    public function createOrganisation(string $name, User $user): Organisation
    {
        $organisation = new Organisation();

        $organisation->name = $name;
        $organisation->owner_user_id = $user->id;
        $organisation->trial_end = now()->addDays(30);
        $organisation->subscribed = false;

        if (!$organisation->save()) {
            throw new \DomainException('Error creating an organisation');
        }

        event(new OrganisationCreated($organisation));

        return $organisation;
    }

    /**
     * @param OrganisationFilterData $filterData
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getList(OrganisationFilterData $filterData)
    {
        return (new Organisation())->getList($filterData);
    }
}
