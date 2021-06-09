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

    protected $availableIncludes = ['user'];

    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        return [
            'name' => $organisation->name,
            'trial_ends_at' => $organisation->trial_end->timestamp,
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Organisation $organisation)
    {
        return $this->item($organisation->owner, new UserTransformer());
    }
}
