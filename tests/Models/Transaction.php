<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models;

final readonly class Transaction
{
    public function __construct(public int $id, public Amount $amount)
    {
    }
}
