<?php

declare(strict_types=1);

namespace App\Serializers;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class DefaultSerializer
 * @package App\Serializers
 */
class DefaultSerializer extends ArraySerializer
{
    /**
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data): array
    {
        return $data;
    }
}
