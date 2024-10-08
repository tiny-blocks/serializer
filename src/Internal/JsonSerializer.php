<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal;

final readonly class JsonSerializer
{
    public function serialize(array $data): string
    {
        $isAllEmpty = static function (array $items): bool {
            return array_reduce($items, static fn(bool $carry, mixed $item): bool => $carry && empty($item), true);
        };

        $serializeToJson = static fn(mixed $value): string => is_string(
            $json = json_encode($value, JSON_PRESERVE_ZERO_FRACTION)
        ) ? $json : '[]';

        if ($isAllEmpty($data)) {
            return '[]';
        }

        $isSerializable = static fn(mixed $item): bool => !is_scalar($item);

        if (count($data) === 1 && isset($data[0]) && $isSerializable($data[0])) {
            return $serializeToJson($data[0]);
        }

        return $serializeToJson($data);
    }
}
