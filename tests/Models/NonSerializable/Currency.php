<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\NonSerializable;

enum Currency: string
{
    case BRL = 'BRL';
    case USD = 'USD';
    case EUR = 'EUR';
}
