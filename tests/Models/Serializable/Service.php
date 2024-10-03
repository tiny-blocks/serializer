<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Models\Serializable;

use Closure;
use TinyBlocks\Serializer\Serializer;
use TinyBlocks\Serializer\SerializerAdapter;

final class Service implements Serializer
{
    use SerializerAdapter;

    public function __construct(public Closure $action)
    {
    }
}
