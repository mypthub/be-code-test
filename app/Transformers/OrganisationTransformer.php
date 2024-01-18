<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Organisation;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
    protected array $availableIncludes = ['owner'];
    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        return [
            'name' => $organisation->name,
            'trial_end' => $organisation->trial_end->timestamp ?? null,
            'subscribed' => $organisation->subscribed,
            'created_at' => $organisation->created_at->timestamp
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return Item
     */
    public function includeOwner(Organisation $organisation): Item
    {
        return $this->item($organisation->owner, new UserTransformer());
    }
}
