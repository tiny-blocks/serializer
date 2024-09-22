<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal;

final readonly class JsonSerializer
{
    public function serialize(array $data): string
    {
        $isSingleItem = count($data) === 1;
        $dataToSerialize = $isSingleItem ? $data[0] : $data;

        return json_encode($dataToSerialize, JSON_PRESERVE_ZERO_FRACTION);
    }
}
