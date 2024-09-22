<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\Serializable;

use TinyBlocks\Serializer\Serializer;
use TinyBlocks\Serializer\SerializerAdapter;

final readonly class Shipping implements Serializer
{
    use SerializerAdapter;

    public function __construct(public int $id, public Addresses $addresses)
    {
    }
}
