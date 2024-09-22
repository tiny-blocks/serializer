<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\Serializable;

use TinyBlocks\Serializer\Serializer;
use TinyBlocks\Serializer\SerializerAdapter;

final readonly class Address implements Serializer
{
    use SerializerAdapter;

    public function __construct(
        public string $city,
        public State $state,
        public string $street,
        public int $number,
        public Country $country
    ) {
    }
}
