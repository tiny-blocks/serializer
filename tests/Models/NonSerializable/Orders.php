<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\NonSerializable;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class Orders implements IteratorAggregate
{
    private array $orders;

    public function __construct(public iterable $elements = [])
    {
        $this->orders = is_array($elements) ? $elements : iterator_to_array($elements);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->orders);
    }
}
