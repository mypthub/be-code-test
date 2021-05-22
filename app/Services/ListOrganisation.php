<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;

/**
 * Class ListOrganisation
 * @package App\Services
 */
class ListOrganisation
{
    /**
     * @param array $attributes
     *
     * @return Organisation
     */
    public function listOrganisation( string $filter)
    {
        try {
            $organisation = new Organisation();
            if (!empty($filter))
            {
                switch($filter)
                {
                    case('subbed'): 
                            $organisation = $organisation->where('subscribed',1)->get();
                            break;
                    case('trial'):
                            $organisation = $organisation->where('subscribed',0)->get();
                            break;
                    default:
                            $organisation = $organisation->get();

                }
                
            }
            //$organisationData = $organisation->get();
        } catch (Throwable $e) {
            report($e);
            return false;
        }

        return $organisation;
    
    }
}
