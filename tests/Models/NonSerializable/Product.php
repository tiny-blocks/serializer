<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\NonSerializable;

use ArrayIterator;

final class Product
{
    public function __construct(
        public string $name,
        public Amount $amount,
        public array $features,
        public ArrayIterator $stockBatch
    ) {
    }
}
