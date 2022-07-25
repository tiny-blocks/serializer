<?php

namespace TinyBlocks\Serializer;

interface Serializer
{
    /**
     * Returns object representation in JSON format.
     * @return string
     */
    public function toJson(): string;

    /**
     * Return object representation in array format.
     * @return array
     */
    public function toArray(): array;
}
