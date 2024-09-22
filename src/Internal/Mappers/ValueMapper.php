<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal\Mappers;

use BackedEnum;
use DateTimeImmutable;
use TinyBlocks\Serializer\Internal\Formatters\DateTimeFormatter;
use TinyBlocks\Serializer\SerializeKeys;
use UnitEnum;

final readonly class ValueMapper
{
    private DateTimeFormatter $dateTimeFormatter;

    public function __construct(private SerializeKeys $serializeKeys)
    {
        $this->dateTimeFormatter = new DateTimeFormatter();
    }

    public function mapFrom(mixed $value): mixed
    {
        $objectMapper = fn(): ObjectMapper => new ObjectMapper(serializeKeys: $this->serializeKeys);

        return match (true) {
            is_a($value, BackedEnum::class)        => $value->value,
            is_a($value, UnitEnum::class)          => $value->name,
            is_a($value, DateTimeImmutable::class) => $this->dateTimeFormatter->format(date: $value),
            is_object($value)                      => $objectMapper()->mapFrom(object: $value),
            default                                => $value
        };
    }
}
