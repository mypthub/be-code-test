<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Organisation;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;
/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'owner'
    ];
    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {       
        $trialEndDate = !empty($organisation->trial_end) ? Carbon::createFromFormat('Y-m-d H:i:s', $organisation->trial_end)->format('Y-m-d H:i:s') : '';
        return [
            'organisation_id' => (int) $organisation->id,
            'name' => $organisation->name,
            'trial_start_timestamp' => strtotime(Carbon::createFromFormat('Y-m-d H:i:s', $organisation->created_at)->format('Y-m-d H:i:s')),
            'trial_end_timestamp' => strtotime($trialEndDate)            
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner(Organisation $organisation)
    {
        return $this->item($organisation->owner, new UserTransformer());
    }
}
