<?php

namespace TinyBlocks\Serializer;

use ReflectionClass;

trait SerializerAdapter
{
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRESERVE_ZERO_FRACTION);
    }

    public function toArray(): array
    {
        $values = get_object_vars($this);

        return $this->mapOf(values: $values);
    }

    private function mapOf(array $values): array
    {
        $mappedValues = [];

        foreach ($values as $key => $value) {
            if (is_object($value)) {
                $mappedValues[$key] = $this->mapOf(values: $this->ofObject(object: $value));
                continue;
            }

            if (is_array($value)) {
                $mappedValues[$key] = $this->mapOf(values: $value);
                continue;
            }

            $mappedValues[$key] = $value;
        }

        return $mappedValues;
    }

    private function ofObject(object $object): array
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
