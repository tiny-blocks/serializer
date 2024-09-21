<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models;

final readonly class Amount
{
    public function __construct(public float $value, public string $currency)
    {
    }
}
