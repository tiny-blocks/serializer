<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal;

use ReflectionClass;

final readonly class Serializable
{
    public function __construct(private iterable $iterable, private bool $shouldPreserveKeys)
    {
    }

    public function serializeToArray(): array
    {
        $values = match (true) {
            is_array($this->iterable) => $this->iterable,
            default                   => iterator_to_array($this->iterable, $this->shouldPreserveKeys)
        };

        return $this->mapFromArray(values: $values);
    }

    private function mapFromArray(array $values): array
    {
        $mappedValues = [];

        foreach ($values as $key => $value) {
            if (is_object($value)) {
                $mappedValues[$key] = $this->mapFromArray(values: $this->mapFromObject(object: $value));
                continue;
            }

            if (is_array($value)) {
                $mappedValues[$key] = $this->mapFromArray(values: $value);
                continue;
            }

            $mappedValues[$key] = $value;
        }

        return $mappedValues;
    }

    private function mapFromObject(object $object): array
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();
        $mappedValues = [];

        foreach ($properties as $property) {
            $mappedValues[$property->getName()] = $property->getValue($object);
        }

        return $mappedValues;
    }
}
