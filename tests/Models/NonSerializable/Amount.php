<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\NonSerializable;

final readonly class Amount
{
    public function __construct(public float $value, public Currency $currency)
    {
    }

    public function toArray(): array
    {
        return [
            'value'    => $this->value,
            'currency' => $this->currency
        ];
    }
}
