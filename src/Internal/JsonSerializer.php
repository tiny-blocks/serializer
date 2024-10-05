<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal;

final readonly class JsonSerializer
{
    public function serialize(array $data): string
    {
        $isSingleItem = static fn(array $data): bool => array_keys($data) !== range(0, count($data) - 1);
        $dataToSerialize = $isSingleItem($data) ? $data : ($data[0] ?? null);

        $json = json_encode($dataToSerialize, JSON_PRESERVE_ZERO_FRACTION);

        return is_string($json) ? $json : '{}';
    }
}
