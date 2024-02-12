<?php

namespace TinyBlocks\Serializer\Mock;

final readonly class AmountMock
{
    public function __construct(private float $value, private string $currency)
    {
    }
}
