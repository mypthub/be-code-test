<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Organisation;
use App\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
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
            'id' => (int) $organisation->id,
            'name' => (string) $organisation->name,
            'trial_end' => (int) Carbon::parse($organisation->trial_end)->timestamp,
            'subscribed' => (int) $organisation->subscribed,
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Organisation $organisation)
    {
        return $this->item($organisation->user, new UserTransformer());
    }
}
