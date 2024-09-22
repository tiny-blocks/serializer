<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use TinyBlocks\Serializer\Internal\ArraySerializer;
use TinyBlocks\Serializer\Internal\JsonSerializer;

trait SerializerAdapter
{
    public function toJson(): string
    {
        return (new JsonSerializer())->serialize(data: $this->toArray());
    }

    public function toArray(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): array
    {
        $arraySerializer = new ArraySerializer(iterable: get_object_vars($this));

        return $arraySerializer->toArray(serializeKeys: $serializeKeys);
    }
}
