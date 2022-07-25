<?php

namespace TinyBlocks\Serializer;

use PHPUnit\Framework\TestCase;
use TinyBlocks\Serializer\Mock\AmountMock;
use TinyBlocks\Serializer\Mock\ComplexValueMock;
use TinyBlocks\Serializer\Mock\MultipleValueMock;
use TinyBlocks\Serializer\Mock\SingleValueMock;
use TinyBlocks\Serializer\Mock\TransactionMock;

final class ComplexValueTest extends TestCase
{
    public function testToJson(): void
    {
        $actual = new ComplexValueMock(
            single: new SingleValueMock(id: 1000),
            multiple: new MultipleValueMock(
                id: 999,
                transactions: [
                    new TransactionMock(id: 1, amount: new AmountMock(value: 0.99, currency: 'USD')),
                    new TransactionMock(id: 2, amount: new AmountMock(value: 10.55, currency: 'USD'))
                ]
            )
        );

        $expected = '{"single":{"id":1000},"multiple":{"id":999,"transactions":[{"id":1,"amount":{"value":0.99,"currency":"USD"}},{"id":2,"amount":{"value":10.55,"currency":"USD"}}]}}';

        self::assertSame($expected, $actual->toJson());
    }

    public function testToArray(): void
    {
        $actual = new ComplexValueMock(
            single: new SingleValueMock(id: 1000),
            multiple: new MultipleValueMock(
                id: 999,
                transactions: [
                    new TransactionMock(id: 1, amount: new AmountMock(value: 0.99, currency: 'USD')),
                    new TransactionMock(id: 2, amount: new AmountMock(value: 10.55, currency: 'USD'))
                ]
            )
        );

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

        self::assertSame($expected, $actual->toArray());
    }
}
