<?php

namespace TinyBlocks\Serializer\Mock;

use TinyBlocks\Serializer\Serializer;
use TinyBlocks\Serializer\SerializerAdapter;

final class SingleValueMock implements Serializer
{
    use SerializerAdapter;

    public function __construct(private readonly int $id)
    {
    }
}
