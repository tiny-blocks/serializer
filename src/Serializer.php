<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

/**
 * Provides methods for serializing objects to JSON and array formats.
 *
 * @template Key of array-key
 * @template Value of mixed
 */
interface Serializer
{
    /**
     * Returns the object representation in JSON format.
     *
     * @return string The JSON representation of the object.
     */
    public function toJson(): string;

    /**
     * Converts the object to an array representation.
     *
     * @param SerializeKeys $serializeKeys Optional serialization configuration.
     * @return array<Key, Value> The array representation of the object.
     */
    public function toArray(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): array;
}
