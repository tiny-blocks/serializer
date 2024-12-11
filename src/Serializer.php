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
     * The key serialization behavior can be customized using the `SerializeKeys` enum:
     *  - {@see SerializeKeys::DISCARD}: Discards the array keys.
     *  - {@see SerializeKeys::PRESERVE}: Preserves the array keys.
     *
     * By default, `SerializeKeys::PRESERVE` is used.
     *
     * @param SerializeKeys $serializeKeys Optional parameter to define whether array keys
     *                                     should be preserved or discarded.
     * @return string The JSON string representing the object.
     */
    public function toJson(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): string;

    /**
     * Converts the object to an array.
     *
     * The key serialization behavior can be customized using the `SerializeKeys` enum:
     *  - {@see SerializeKeys::DISCARD}: Discards the array keys.
     *  - {@see SerializeKeys::PRESERVE}: Preserves the array keys.
     *
     * By default, `SerializeKeys::PRESERVE` is used.
     *
     * @param SerializeKeys $serializeKeys Optional parameter to define whether array keys
     *                                     should be preserved or discarded.
     * @return array<Key, Value> The array representation of the object.
     */
    public function toArray(SerializeKeys $serializeKeys = SerializeKeys::PRESERVE): array;
}
