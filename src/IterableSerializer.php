<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use TinyBlocks\Serializer\Internal\Serializable;

final readonly class IterableSerializer implements Serializer
{
    public function __construct(private iterable $iterable)
    {
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRESERVE_ZERO_FRACTION);
    }

    public function toArray(bool $shouldPreserveKeys = self::PRESERVE_KEYS): array
    {
        $serializable = new Serializable(iterable: $this->iterable, shouldPreserveKeys: $shouldPreserveKeys);

        return $serializable->serializeToArray();
    }
}
