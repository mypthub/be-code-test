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
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user'
    ];

    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        return [
            'name' => $organisation->name,
            'trial_end' => $organisation->trial_end ? $organisation->trial_end->unix() : null,
            'created_at' => $organisation->created_at->unix(),
            'is_subscribed' => $organisation->subscribed,
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return Item
     */
    public function includeUser(Organisation $organisation): Item
    {
        return $this->item($organisation->owner, new UserTransformer());
    }
}
