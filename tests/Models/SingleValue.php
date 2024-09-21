<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models;

use TinyBlocks\Serializer\Serializer;
use TinyBlocks\Serializer\SerializerAdapter;

final class SingleValue implements Serializer
{
    use SerializerAdapter;

    public function __construct(private readonly int $id)
    {
    }
}
