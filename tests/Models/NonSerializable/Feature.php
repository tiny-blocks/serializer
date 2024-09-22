<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\NonSerializable;

final class Feature
{
    public function __construct(public Color $color)
    {
    }
}
