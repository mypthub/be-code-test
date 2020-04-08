<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Organisation;
use League\Fractal\TransformerAbstract;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        $owner = $this->includeUser($organisation);

        return [
            'id' => (int) $organisation->id,
            'name' => (string) $organisation->name,
            'owner' => [
                'user_id' => (int) $organisation->owner_user_id,
                'user_name' => $owner['name'],
                'user_email' => $owner['email']
            ], 
            'subscribed' => (bool) $organisation->subscribed,
            'trial_end' => ($organisation->trial_end ? (int) strtotime((string)$organisation->trial_end) : null)
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Organisation $organisation)
    {
        $UserTransformer = new UserTransformer();
        $owner = $UserTransformer->transform($organisation->owner);

        return $owner;
    }
}
