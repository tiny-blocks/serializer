<?php

namespace TinyBlocks\Serializer\Mock;

final class AmountMock
{
    public function __construct(private readonly float $value, private readonly string $currency)
    {
    }
}
