<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal;

final readonly class JsonSerializer
{
    public function serialize(array $data): string
    {
        $isSingleItem = count($data) === 1;
        $dataToSerialize = $isSingleItem ? ($data[0] ?? null) : $data;

        $json = json_encode($dataToSerialize, JSON_PRESERVE_ZERO_FRACTION);

        if (!is_string($json) || $json === 'null') {
            return $isSingleItem ? '{}' : '[]';
        }

        return $json;
    }
}
