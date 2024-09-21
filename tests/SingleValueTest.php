<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use PHPUnit\Framework\TestCase;
use TinyBlocks\Serializer\Models\SingleValue;

final class SingleValueTest extends TestCase
{
    public function testToJson(): void
    {
        /**
         * @Given a SingleValue object with an id
         */
        $singleValue = new SingleValue(id: 1);

        /** @When serializing the object to JSON */
        $actual = $singleValue->toJson();

        /** @Then the output should match the expected JSON format */
        self::assertSame('{"id":1}', $actual);
    }

    public function testToArray(): void
    {
        /**
         * @Given a SingleValue object with an id
         */
        $singleValue = new SingleValue(id: 1);

        /** @When converting the object to an array */
        $actual = $singleValue->toArray();

        /** @Then the output should match the expected array structure */
        self::assertSame(['id' => 1], $actual);
    }
}
