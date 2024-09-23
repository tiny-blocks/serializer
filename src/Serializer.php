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
     * Serializes the object to a JSON string.
     *
     * @param SerializeKeys $serializeKeys Optional parameter to define how keys
     *                                     should be serialized (default: PRESERVE).
     * @return string The JSON string representing the object.
     */
    public function toJson(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): string;

    /**
     * Converts the object to an array.
     *
     * @param SerializeKeys $serializeKeys Optional parameter to define how keys
     *                                     should be serialized (default: PRESERVE).
     * @return array<Key, Value> The array representation of the object.
     */
    public function toArray(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): array;
}
