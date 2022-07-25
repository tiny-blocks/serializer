<?php

namespace TinyBlocks\Serializer\Mock;

use TinyBlocks\Serializer\Serializer;
use TinyBlocks\Serializer\SerializerAdapter;

final class MultipleValueMock implements Serializer
{
    use SerializerAdapter;

    public function __construct(private readonly int $id, private readonly array $transactions)
    {
    }
}
