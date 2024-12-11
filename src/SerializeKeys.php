<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

/**
 * Represents the options for how keys should be handled during serialization.
 */
enum SerializeKeys
{
    /**
     * The option indicating that keys should be discarded during serialization.
     */
    case DISCARD;

    /**
     * The option indicating that keys should be preserved during serialization.
     */
    case PRESERVE;

    public function shouldPreserveKeys(): bool
    {
        return $this === self::PRESERVE;
    }
}
