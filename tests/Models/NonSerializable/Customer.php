<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\NonSerializable;

final class Customer
{
    public function __construct(private readonly string $id, public Orders $orders)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
