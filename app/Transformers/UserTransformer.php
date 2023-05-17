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
     * @param User $User
     *
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'id'            => (int) $user->id,
            'name'          => (string) $user->name,
            'email'         => (string) $user->email,
        ];
    }

   
}
