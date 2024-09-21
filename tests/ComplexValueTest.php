<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use PHPUnit\Framework\TestCase;
use TinyBlocks\Serializer\Models\Amount;
use TinyBlocks\Serializer\Models\ComplexValue;
use TinyBlocks\Serializer\Models\MultipleValue;
use TinyBlocks\Serializer\Models\SingleValue;
use TinyBlocks\Serializer\Models\Transaction;

final class ComplexValueTest extends TestCase
{
    public function testToJson(): void
    {
        /**
         * @Given a ComplexValue object with a single value and multiple transactions
         */
        $complexValue = new ComplexValue(
            single: new SingleValue(id: 1000),
            multiple: new MultipleValue(
                id: 999,
                transactions: [
                    new Transaction(id: 1, amount: new Amount(value: 0.99, currency: 'USD')),
                    new Transaction(id: 2, amount: new Amount(value: 10.55, currency: 'USD'))
                ]
            )
        );

        /** @When serializing the object to JSON */
        $actual = $complexValue->toJson();

        /** @Then the output should match the expected JSON format */
        $expected = '{"single":{"id":1000},"multiple":{"id":999,"transactions":[{"id":1,"amount":{"value":0.99,"currency":"USD"}},{"id":2,"amount":{"value":10.55,"currency":"USD"}}]}}';
        self::assertSame($expected, $actual);
    }

    public function testToArray(): void
    {
        /**
         * @Given a ComplexValue object with a single value and multiple transactions
         */
        $complexValue = new ComplexValue(
            single: new SingleValue(id: 1000),
            multiple: new MultipleValue(
                id: 999,
                transactions: [
                    new Transaction(id: 1, amount: new Amount(value: 0.99, currency: 'USD')),
                    new Transaction(id: 2, amount: new Amount(value: 10.55, currency: 'USD'))
                ]
            )
        );

        /** @When converting the object to an array */
        $actual = $complexValue->toArray();

        /** @Then the output should match the expected array structure */
        $expected = [
            'single'   => ['id' => 1000],
            'multiple' => [
                'id'           => 999,
                'transactions' => [
                    [
                        'id'     => 1,
                        'amount' => ['value' => 0.99, 'currency' => 'USD']
                    ],
                    [
                        'id'     => 2,
                        'amount' => ['value' => 10.55, 'currency' => 'USD']
                    ]
                ],
            ]
        ];
        self::assertSame($expected, $actual);
    }
}
