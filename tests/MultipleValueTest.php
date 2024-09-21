<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use PHPUnit\Framework\TestCase;
use TinyBlocks\Serializer\Models\Amount;
use TinyBlocks\Serializer\Models\MultipleValue;
use TinyBlocks\Serializer\Models\Transaction;

final class MultipleValueTest extends TestCase
{
    public function testToJson(): void
    {
        /**
         * @Given a MultipleValue object with transactions
         */
        $multipleValue = new MultipleValue(
            id: 123,
            transactions: [
                new Transaction(id: 100, amount: new Amount(value: 10.0, currency: 'BRL')),
                new Transaction(id: 200, amount: new Amount(value: 11.01, currency: 'BRL'))
            ]
        );

        /** @When serializing the object to JSON */
        $actual = $multipleValue->toJson();

        /** @Then the output should match the expected JSON format */
        $expected = '{"id":123,"transactions":[{"id":100,"amount":{"value":10.0,"currency":"BRL"}},{"id":200,"amount":{"value":11.01,"currency":"BRL"}}]}';
        self::assertSame($expected, $actual);
    }

    public function testToArray(): void
    {
        /**
         * @Given a MultipleValue object with transactions
         */
        $multipleValue = new MultipleValue(
            id: 123,
            transactions: [
                new Transaction(id: 100, amount: new Amount(value: 10.0, currency: 'BRL')),
                new Transaction(id: 200, amount: new Amount(value: 11.01, currency: 'BRL'))
            ]
        );

        /** @When converting the object to an array */
        $actual = $multipleValue->toArray();

        /** @Then the output should match the expected array structure */
        $expected = [
            'id'           => 123,
            'transactions' => [
                [
                    'id'     => 100,
                    'amount' => ['value' => 10.0, 'currency' => 'BRL']
                ],
                [
                    'id'     => 200,
                    'amount' => ['value' => 11.01, 'currency' => 'BRL']
                ]
            ]
        ];
        self::assertSame($expected, $actual);
    }
}
