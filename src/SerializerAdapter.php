<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use TinyBlocks\Serializer\Internal\ArraySerializer;
use TinyBlocks\Serializer\Internal\JsonSerializer;

/**
 * A trait that provides serialization methods to convert objects into JSON and array formats.
 *
 * @template Key of array-key
 * @template Value of mixed
 */
trait SerializerAdapter
{
    public function toJson(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): string
    {
        return (new JsonSerializer())->serialize(data: $this->toArray(serializeKeys: $serializeKeys));
    }

    public function toArray(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): array
    {
        $arraySerializer = new ArraySerializer(iterable: get_object_vars($this));

        return $arraySerializer->toArray(serializeKeys: $serializeKeys);
    }
}
