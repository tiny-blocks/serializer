<?php

namespace TinyBlocks\Serializer;

use PHPUnit\Framework\TestCase;
use TinyBlocks\Serializer\Mock\SingleValueMock;

final class SingleValueTest extends TestCase
{
    public function testToJson(): void
    {
        $actual = new SingleValueMock(id: 1);

        self::assertSame('{"id":1}', $actual->toJson());
    }

    public function testToArray(): void
    {
        $actual = new SingleValueMock(id: 1);

        self::assertSame(['id' => 1], $actual->toArray());
    }
}
