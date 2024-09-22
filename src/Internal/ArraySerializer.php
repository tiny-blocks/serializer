<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal;

use TinyBlocks\Serializer\Internal\Mappers\Mapper;
use TinyBlocks\Serializer\SerializeKeys;

final readonly class ArraySerializer
{
    public function __construct(private iterable $iterable)
    {
    }

    public function toArray(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): array
    {
        $mapper = new Mapper(serializeKeys: $serializeKeys);
        $shouldPreserveKeys = $serializeKeys && $serializeKeys->shouldPreserveKeys();

        $elements = is_array($this->iterable)
            ? $this->iterable
            : iterator_to_array($this->iterable, $shouldPreserveKeys);

        $mappedValues = array_map(fn(mixed $value): mixed => $mapper->mapFrom(value: $value), $elements);

        return $shouldPreserveKeys ? $mappedValues : array_values($mappedValues);
    }
}
