<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\NonSerializable;

use DateTimeImmutable;

final class Order
{
    public function __construct(public int $id, public iterable $products, public DateTimeImmutable $createdAt)
    {
    }
}
