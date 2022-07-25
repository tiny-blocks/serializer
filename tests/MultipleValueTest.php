<?php

namespace TinyBlocks\Serializer;

use PHPUnit\Framework\TestCase;
use TinyBlocks\Serializer\Mock\AmountMock;
use TinyBlocks\Serializer\Mock\MultipleValueMock;
use TinyBlocks\Serializer\Mock\TransactionMock;

final class MultipleValueTest extends TestCase
{
    public function testToJson(): void
    {
        $actual = new MultipleValueMock(
            id: 123,
            transactions: [
                new TransactionMock(id: 100, amount: new AmountMock(value: 10.0, currency: 'BRL')),
                new TransactionMock(id: 200, amount: new AmountMock(value: 11.01, currency: 'BRL'))
            ]
        );

        $expected = '{"id":123,"transactions":[{"id":100,"amount":{"value":10.0,"currency":"BRL"}},{"id":200,"amount":{"value":11.01,"currency":"BRL"}}]}';

        self::assertSame($expected, $actual->toJson());
    }

    public function testToArray(): void
    {
        $actual = new MultipleValueMock(
            id: 123,
            transactions: [
                new TransactionMock(id: 100, amount: new AmountMock(value: 10.0, currency: 'BRL')),
                new TransactionMock(id: 200, amount: new AmountMock(value: 11.01, currency: 'BRL'))
            ]
        );

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

        self::assertSame($expected, $actual->toArray());
    }
}
