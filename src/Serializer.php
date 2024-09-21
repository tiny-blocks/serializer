<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

interface Serializer
{
    /**
     * Define if keys should be preserved in the array.
     */
    public const PRESERVE_KEYS = true;

    /**
     * Returns object representation in JSON format.
     *
     * @return string
     */
    public function toJson(): string;

    /**
     * Return object representation in array format.
     *
     * @param bool $shouldPreserveKeys Whether to preserve keys in the array.
     * @return array
     */
    public function toArray(bool $shouldPreserveKeys = self::PRESERVE_KEYS): array;
}
