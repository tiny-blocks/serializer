<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal\Mappers;

use TinyBlocks\Serializer\SerializeKeys;

final readonly class Mapper
{
    private ValueMapper $valueMapper;

    public function __construct(SerializeKeys $serializeKeys)
    {
        $this->valueMapper = new ValueMapper(serializeKeys: $serializeKeys);
    }

    public function mapFrom(mixed $value): mixed
    {
        return $this->valueMapper->mapFrom(value: $value);
    }
}
