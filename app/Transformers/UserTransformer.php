<?php

declare(strict_types=1);

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Transformers
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'owner_id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email,            
        ];
    }    
}
