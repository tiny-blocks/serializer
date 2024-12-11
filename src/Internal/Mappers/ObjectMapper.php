<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal\Mappers;

use ReflectionClass;
use TinyBlocks\Serializer\SerializeKeys;

final readonly class ObjectMapper
{
    private ValueMapper $valueMapper;

    private bool $shouldPreserveKeys;

    public function __construct(private SerializeKeys $serializeKeys)
    {
        $this->valueMapper = new ValueMapper(serializeKeys: $this->serializeKeys);
        $this->shouldPreserveKeys = $this->serializeKeys->shouldPreserveKeys();
    }

    public function mapFrom(object $object): array
    {
        $reflection = new ReflectionClass($object);
        $mappedValues = [];

        $hasToArrayMethod = fn(mixed $value): bool => is_object($value) && method_exists($value, 'toArray');

        foreach ($reflection->getProperties() as $property) {
            $value = $property->getValue($object);

            if ($hasToArrayMethod($value)) {
                $value = $value->toArray();
            }

            if (is_iterable($value)) {
                $value = is_array($value) ? $value : iterator_to_array($value, $this->shouldPreserveKeys);
                $value = array_map(
                    fn(mixed $item): mixed => $hasToArrayMethod($item)
                        ? $item->toArray()
                        : $this->valueMapper->mapFrom(value: $item),
                    $value
                );
            }

            if (is_scalar($value) || $property->isPublic()) {
                $mappedValues[$property->getName()] = $this->valueMapper->mapFrom(value: $value);
                continue;
            }

            $value = $this->valueMapper->mapFrom(value: $value);

            if (is_array($value)) {
                $mappedValues = $value;
            }
        }

        return $mappedValues;
    }
}
