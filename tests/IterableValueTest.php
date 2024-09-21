<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use ArrayIterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TinyBlocks\Serializer\Models\Amount;
use TinyBlocks\Serializer\Models\ComplexValue;
use TinyBlocks\Serializer\Models\MultipleValue;
use TinyBlocks\Serializer\Models\SingleValue;
use TinyBlocks\Serializer\Models\Transaction;

final class IterableValueTest extends TestCase
{
    #[DataProvider('jsonConversionDataProvider')]
    public function testConvertToJson(array $iterable, string $expected): void
    {
        /** @Given an iterable containing objects and values */
        $serializable = new IterableSerializer(iterable: $iterable);

        /** @When converting the iterable to JSON */
        $actual = $serializable->toJson();

        /** @Then the output should match the expected JSON */
        self::assertSame($expected, $actual);
    }

    #[DataProvider('objectsDataProvider')]
    public function testSerializeObjects(array $iterable, array $expected): void
    {
        /** @Given a ComplexValue object */
        $serializable = new IterableSerializer(iterable: $iterable);

        /** @When serializing the object to an array */
        $actual = $serializable->toArray();

        /** @Then the output should match the expected structure */
        self::assertSame($expected, $actual);
    }

    #[DataProvider('traversableDataProvider')]
    public function testSerializeTraversable(array $iterable, array $expected): void
    {
        /** @Given an iterable containing values */
        $serializable = new IterableSerializer(iterable: new ArrayIterator($iterable));

        /** @When serializing the iterable to an array */
        $actual = $serializable->toArray(shouldPreserveKeys: false);

        /** @Then the output should match the expected values */
        self::assertSame($expected, $actual);
    }

    #[DataProvider('preserveKeysDataProvider')]
    public function testSerializePreserveKeys(array $iterable, array $expected): void
    {
        /** @Given an associative array */
        $serializable = new IterableSerializer(iterable: $iterable);

        /** @When serializing the array to preserve keys */
        $actual = $serializable->toArray(shouldPreserveKeys: true);

        /** @Then the output should match the expected key-value pairs */
        self::assertSame($expected, $actual);
    }

    #[DataProvider('nestedArrayDataProvider')]
    public function testMapFromArrayHandlesNestedArraysCorrectly(array $iterable, array $expected): void
    {
        /** @Given a nested array structure */
        $serializable = new IterableSerializer(iterable: $iterable);

        /** @When mapping the array */
        $actual = $serializable->toArray();

        /** @Then the output should reflect that both nested arrays were processed */
        self::assertSame($expected, $actual);
    }

    public static function jsonConversionDataProvider(): array
    {
        $complexValue1 = new ComplexValue(
            single: new SingleValue(id: 1001),
            multiple: new MultipleValue(
                id: 500,
                transactions: [
                    new Transaction(id: 1, amount: new Amount(value: 1.99, currency: 'USD'))
                ]
            )
        );

        $complexValue2 = new ComplexValue(
            single: new SingleValue(id: 1002),
            multiple: new MultipleValue(id: 501, transactions: [])
        );

        return [
            'Array of complex objects'           => [
                'iterable' => [$complexValue1, $complexValue2],
                'expected' => json_encode([
                    [
                        'single'   => ['id' => 1001],
                        'multiple' => [
                            'id'           => 500,
                            'transactions' => [
                                [
                                    'id'     => 1,
                                    'amount' => ['value' => 1.99, 'currency' => 'USD'],
                                ]
                            ]
                        ]
                    ],
                    [
                        'single'   => ['id' => 1002],
                        'multiple' => ['id' => 501, 'transactions' => []]
                    ]
                ])
            ],
            'Simple values without keys'         => [
                'iterable' => [1, 'test', 3.14],
                'expected' => json_encode([1, 'test', 3.14])
            ],
            'Associative array with mixed types' => [
                'iterable' => ['a' => 1, 'b' => 'test', 'c' => 3.14],
                'expected' => json_encode(['a' => 1, 'b' => 'test', 'c' => 3.14])
            ]
        ];
    }

    public static function objectsDataProvider(): array
    {
        $complexValue1 = new ComplexValue(
            single: new SingleValue(id: 1000),
            multiple: new MultipleValue(
                id: 999,
                transactions: [
                    new Transaction(id: 1, amount: new Amount(value: 0.99, currency: 'USD')),
                    new Transaction(id: 2, amount: new Amount(value: 10.55, currency: 'USD'))
                ]
            )
        );

        $complexValue2 = new ComplexValue(
            single: new SingleValue(id: 2000),
            multiple: new MultipleValue(id: 888, transactions: [])
        );

        return [
            'Complex value with transactions' => [
                'iterable' => [$complexValue1],
                'expected' => [
                    [
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
                            ]
                        ]
                    ]
                ]
            ],
            'Multiple complex values'         => [
                'iterable' => [$complexValue2, $complexValue1],
                'expected' => [
                    [
                        'single'   => ['id' => 2000],
                        'multiple' => ['id' => 888, 'transactions' => []],
                    ],
                    [
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
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function traversableDataProvider(): array
    {
        return [
            'Empty array'    => [
                'iterable' => [],
                'expected' => []
            ],
            'Simple numbers' => [
                'iterable' => [1, 2, 3],
                'expected' => [1, 2, 3]
            ],
            'Single element' => [
                'iterable' => [42],
                'expected' => [42]
            ]
        ];
    }

    public static function preserveKeysDataProvider(): array
    {
        return [
            'Empty associative array'             => [
                'iterable' => [],
                'expected' => []
            ],
            'Simple associative array'            => [
                'iterable' => ['a' => 1, 'b' => 2],
                'expected' => ['a' => 1, 'b' => 2]
            ],
            'Associative array with numeric keys' => [
                'iterable' => [0 => 'first', 1 => 'second'],
                'expected' => [0 => 'first', 1 => 'second']
            ]
        ];
    }

    public static function nestedArrayDataProvider(): array
    {
        return [
            'Empty nested array'        => [
                'iterable' => [],
                'expected' => []
            ],
            'Nested arrays with values' => [
                'iterable' => [
                    'first'  => [
                        'a' => 1,
                        'b' => 2
                    ],
                    'second' => [
                        'c' => 3,
                        'd' => 4
                    ]
                ],
                'expected' => [
                    'first'  => [
                        'a' => 1,
                        'b' => 2
                    ],
                    'second' => [
                        'c' => 3,
                        'd' => 4
                    ]
                ]
            ]
        ];
    }
}
