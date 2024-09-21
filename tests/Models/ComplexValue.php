<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models;

use TinyBlocks\Serializer\Serializer;
use TinyBlocks\Serializer\SerializerAdapter;

final class ComplexValue implements Serializer
{
    use SerializerAdapter;

    public function __construct(private readonly SingleValue $single, private readonly MultipleValue $multiple)
    {
    }
}
