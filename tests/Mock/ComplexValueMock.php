<?php

namespace TinyBlocks\Serializer\Mock;

use TinyBlocks\Serializer\Serializer;
use TinyBlocks\Serializer\SerializerAdapter;

final class ComplexValueMock implements Serializer
{
    use SerializerAdapter;

    public function __construct(private readonly SingleValueMock $single, private readonly MultipleValueMock $multiple)
    {
    }
}
