<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

enum SerializeKeys
{
    case DISCARD;
    case PRESERVE;

    public function shouldPreserveKeys(): bool
    {
        return $this === self::PRESERVE;
    }
}
