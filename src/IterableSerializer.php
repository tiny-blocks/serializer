<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use TinyBlocks\Serializer\Internal\ArraySerializer;
use TinyBlocks\Serializer\Internal\JsonSerializer;

/**
 * A serializer for iterable objects that supports JSON and array formats.
 *
 * @template Key of array-key
 * @template Value of mixed
 * @implements Serializer<Key, Value>
 */
final readonly class IterableSerializer implements Serializer
{
    private JsonSerializer $jsonSerializer;
    private ArraySerializer $arraySerializer;

    public function __construct(iterable $iterable)
    {
        $this->jsonSerializer = new JsonSerializer();
        $this->arraySerializer = new ArraySerializer(iterable: $iterable);
    }

    public function toJson(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): string
    {
        $data = $this->arraySerializer->toArray(serializeKeys: $serializeKeys);

        return $this->jsonSerializer->serialize(data: $data);
    }

    public function toArray(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): array
    {
        return $this->arraySerializer->toArray(serializeKeys: $serializeKeys);
    }
}
