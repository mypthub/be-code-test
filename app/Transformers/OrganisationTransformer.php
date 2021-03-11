<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Organisation;
use League\Fractal\TransformerAbstract;
use Illuminate\Support\Facades\App;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract{

    protected $availableIncludes = [
        'user'
    ];

    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array {
        $organisationDetail = [
            'name' => $organisation->name,
            'trial_end' => $organisation->trial_end,
            'subscribed' => $organisation->subscribed,
            'created_at' => $organisation->created_at,
            'updated_at' => $organisation->updated_at,
            'deleted_at' => $organisation->deleted_at,
        ];
        return $organisationDetail;
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Organisation $organisation){
        return $this->item($organisation->owner, new UserTransformer());
        //eturn $this->item($user->role, App::make(RoleTransformer::class));
    }
}
