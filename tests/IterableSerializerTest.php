<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use ArrayIterator;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TinyBlocks\Serializer\Models\NonSerializable\Amount;
use TinyBlocks\Serializer\Models\NonSerializable\Color;
use TinyBlocks\Serializer\Models\NonSerializable\Currency;
use TinyBlocks\Serializer\Models\NonSerializable\Customer;
use TinyBlocks\Serializer\Models\NonSerializable\Feature;
use TinyBlocks\Serializer\Models\NonSerializable\Order;
use TinyBlocks\Serializer\Models\NonSerializable\Orders;
use TinyBlocks\Serializer\Models\NonSerializable\Product;

final class IterableSerializerTest extends TestCase
{
    #[DataProvider('discardKeysDataProvider')]
    public function testDiscardKeys(iterable $iterable, array $expected): void
    {
        /** @Given an associative array of primitive values */
        $serializable = new IterableSerializer(iterable: $iterable);

        /** @When serializing the array using toArray while discarding keys */
        $actual = $serializable->toArray(serializeKeys: SerializeKeys::DISCARD);

        /** @Then the output should discard the keys and match the expected structure */
        self::assertSame($expected, $actual);
    }

    #[DataProvider('preserveKeysDataProvider')]
    public function testPreserveKeys(iterable $iterable, array $expected): void
    {
        /** @Given an associative array of primitive values */
        $serializable = new IterableSerializer(iterable: $iterable);

        /** @When serializing the array using toArray while preserving keys */
        $actual = $serializable->toArray();

        /** @Then the output should preserve the keys and match the expected structure */
        self::assertSame($expected, $actual);
    }

    #[DataProvider('toJsonDataProvider')]
    public function testSerializeToJson(iterable $iterable, string $expected): void
    {
        /** @Given a collection of objects with various attributes */
        $serializable = new IterableSerializer(iterable: $iterable);

        /** @When serializing the collection of objects to JSON */
        $actual = $serializable->toJson();

        /** @Then the output should match the expected JSON structure for the collection of objects */
        self::assertJsonStringEqualsJsonString($expected, $actual);
    }

    #[DataProvider('toArrayDataProvider')]
    public function testSerializeToArray(iterable $iterable, array $expected): void
    {
        /** @Given a collection of objects with various attributes */
        $serializable = new IterableSerializer(iterable: $iterable);

        /** @When serializing the collection of objects to an array */
        $actual = $serializable->toArray();

        /** @Then the output should match the expected structure for the collection of objects */
        self::assertSame($expected, $actual);
    }

    public static function toJsonDataProvider(): array
    {
        $customerWithNoOrders = new Customer(
            id: '311dbf69-610e-41ef-b435-cf5654776bc5',
            orders: new Orders()
        );

        $customerWithSingleOrder = new Customer(
            id: 'abcdefab-abcd-abcd-abcd-abcdefabcdef',
            orders: new Orders(elements: [
                new Order(
                    id: 20000000,
                    products: [
                        new Product(
                            name: 'Product Z',
                            amount: new Amount(value: 299.99, currency: Currency::USD),
                            features: [new Feature(color: Color::WHITE)],
                            stockBatch: new ArrayIterator([100])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00')
                )
            ])
        );

        $customerWithMixedOrders = new Customer(
            id: '56789abc-5678-5678-5678-56789abcdef0',
            orders: new Orders(elements: [
                new Order(
                    id: 30000000,
                    products: [
                        new Product(
                            name: 'Product A',
                            amount: new Amount(value: 50.0, currency: Currency::BRL),
                            features: [],
                            stockBatch: new ArrayIterator([])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat(
                        DateTimeInterface::ISO8601_EXPANDED,
                        '1997-01-01T01:15:00+00:00'
                    )
                ),
                new Order(
                    id: 30000001,
                    products: [
                        new Product(
                            name: 'Product B',
                            amount: new Amount(value: 150.75, currency: Currency::EUR),
                            features: [new Feature(color: Color::RED)],
                            stockBatch: new ArrayIterator([5])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat(
                        DateTimeInterface::ATOM,
                        '1997-01-01T20:00:00+00:00'
                    )
                )
            ])
        );

        $customerWithMultipleOrders = new Customer(
            id: '88ecb5f8-ef13-4026-a002-9baad15f7a26',
            orders: new Orders(elements: [
                new Order(
                    id: 10000000,
                    products: [
                        new Product(
                            name: 'Product X',
                            amount: new Amount(value: 1099.99, currency: Currency::USD),
                            features: [new Feature(color: Color::RED)],
                            stockBatch: new ArrayIterator([45000])
                        ),
                        new Product(
                            name: 'Product Y',
                            amount: new Amount(value: 123.0005, currency: Currency::USD),
                            features: [new Feature(color: Color::BLACK)],
                            stockBatch: new ArrayIterator([3, 6, 9, 12])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2024-01-01 00:00:00')
                ),
                new Order(
                    id: 10000001,
                    products: [
                        new Product(
                            name: 'Product X',
                            amount: new Amount(value: 6066.55, currency: Currency::BRL),
                            features: [new Feature(color: Color::RED)],
                            stockBatch: new ArrayIterator([45000])
                        ),
                        new Product(
                            name: 'Product Y',
                            amount: new Amount(value: 678.36, currency: Currency::BRL),
                            features: [new Feature(color: Color::BLACK)],
                            stockBatch: new ArrayIterator([3, 6, 9, 12])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2024-01-01 00:00:00')
                )
            ])
        );

        return [
            'Customer with no orders'       => [
                'iterable' => [$customerWithNoOrders],
                'expected' => '{"id":"311dbf69-610e-41ef-b435-cf5654776bc5","orders":[]}'
            ],
            'Customer with single order'    => [
                'iterable' => [$customerWithSingleOrder],
                'expected' => '{"id":"abcdefab-abcd-abcd-abcd-abcdefabcdef","orders":[{"id":20000000,"products":[{"name":"Product Z","amount":{"value":299.99,"currency":"USD"},"features":[{"color":"WHITE"}],"stockBatch":[100]}],"createdAt":"2020-01-01T00:00:00-03:00"}]}'
            ],
            'Customer with mixed orders'    => [
                'iterable' => [$customerWithMixedOrders],
                'expected' => '{"id":"56789abc-5678-5678-5678-56789abcdef0","orders":[{"id":30000000,"products":[{"name":"Product A","amount":{"value":50,"currency":"BRL"},"features":[],"stockBatch":[]}],"createdAt":"1997-01-01 01:15:00"},{"id":30000001,"products":[{"name":"Product B","amount":{"value":150.75,"currency":"EUR"},"features":[{"color":"RED"}],"stockBatch":[5]}],"createdAt":"1997-01-01 20:00:00"}]}'
            ],
            'Customer with multiple orders' => [
                'iterable' => [$customerWithMultipleOrders],
                'expected' => '{"id":"88ecb5f8-ef13-4026-a002-9baad15f7a26","orders":[{"id":10000000,"products":[{"name":"Product X","amount":{"value":1099.99,"currency":"USD"},"features":[{"color":"RED"}],"stockBatch":[45000]},{"name":"Product Y","amount":{"value":123.0005,"currency":"USD"},"features":[{"color":"BLACK"}],"stockBatch":[3,6,9,12]}],"createdAt":"2024-01-01T00:00:00-03:00"},{"id":10000001,"products":[{"name":"Product X","amount":{"value":6066.55,"currency":"BRL"},"features":[{"color":"RED"}],"stockBatch":[45000]},{"name":"Product Y","amount":{"value":678.36,"currency":"BRL"},"features":[{"color":"BLACK"}],"stockBatch":[3,6,9,12]}],"createdAt":"2024-01-01T00:00:00-03:00"}]}'
            ]
        ];
    }

    public static function toArrayDataProvider(): array
    {
        $product = new Product(
            name: 'Product Z',
            amount: new Amount(value: 299.99, currency: Currency::USD),
            features: [],
            stockBatch: new ArrayIterator([100])
        );

        $customerWithNoOrders = new Customer(
            id: '12345678-1234-1234-1234-123456789abc',
            orders: new Orders()
        );

        $customerWithSingleOrder = new Customer(
            id: 'abcdefab-abcd-abcd-abcd-abcdefabcdef',
            orders: new Orders(elements: [
                new Order(
                    id: 20000000,
                    products: [$product],
                    createdAt: DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00')
                )
            ])
        );

        $customerWithMixedOrders = new Customer(
            id: '56789abc-5678-5678-5678-56789abcdef0',
            orders: new Orders(elements: [
                new Order(
                    id: 30000000,
                    products: [
                        new Product(
                            name: 'Product A',
                            amount: new Amount(value: 50.0, currency: Currency::BRL),
                            features: [],
                            stockBatch: new ArrayIterator([])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat(
                        DateTimeInterface::ISO8601_EXPANDED,
                        '1997-01-01T01:15:00+00:00'
                    )
                ),
                new Order(
                    id: 30000001,
                    products: [
                        new Product(
                            name: 'Product B',
                            amount: new Amount(value: 150.75, currency: Currency::EUR),
                            features: [new Feature(color: Color::RED)],
                            stockBatch: new ArrayIterator([5])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '1997-01-01 01:15:00')
                ),
                new Order(
                    id: 30000002,
                    products: [
                        new Product(
                            name: 'Product C',
                            amount: new Amount(value: 99.99, currency: Currency::USD),
                            features: [],
                            stockBatch: new ArrayIterator([10])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '1997-01-01 02:30:00')
                )
            ])
        );

        $customerWithMultipleOrders = new Customer(
            id: '88ecb5f8-ef13-4026-a002-9baad15f7a26',
            orders: new Orders(elements: [
                new Order(
                    id: 10000000,
                    products: [
                        new Product(
                            name: 'Product X',
                            amount: new Amount(value: 1099.99, currency: Currency::USD),
                            features: [new Feature(color: Color::RED)],
                            stockBatch: new ArrayIterator([45000])
                        ),
                        new Product(
                            name: 'Product Y',
                            amount: new Amount(value: 123.0005, currency: Currency::USD),
                            features: [new Feature(color: Color::BLACK)],
                            stockBatch: new ArrayIterator([3, 6, 9, 12])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00')
                ),
                new Order(
                    id: 10000001,
                    products: [
                        new Product(
                            name: 'Product X',
                            amount: new Amount(value: 6066.55, currency: Currency::BRL),
                            features: [new Feature(color: Color::RED)],
                            stockBatch: new ArrayIterator([45000])
                        ),
                        new Product(
                            name: 'Product Y',
                            amount: new Amount(value: 678.36, currency: Currency::BRL),
                            features: [new Feature(color: Color::BLACK)],
                            stockBatch: new ArrayIterator([3, 6, 9, 12])
                        )
                    ],
                    createdAt: DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 00:00:00')
                )
            ])
        );

        return [
            'Single product'                => [
                'iterable' => [$product],
                'expected' => [
                    [
                        'name'       => 'Product Z',
                        'amount'     => [
                            'value'    => 299.99,
                            'currency' => Currency::USD->value
                        ],
                        'features'   => [],
                        'stockBatch' => [100]
                    ]
                ]
            ],
            'Customer with no orders'       => [
                'iterable' => [$customerWithNoOrders],
                'expected' => [
                    [
                        'id'     => '12345678-1234-1234-1234-123456789abc',
                        'orders' => []
                    ]
                ]
            ],
            'Customer with single order'    => [
                'iterable' => [$customerWithSingleOrder],
                'expected' => [
                    [
                        'id'     => 'abcdefab-abcd-abcd-abcd-abcdefabcdef',
                        'orders' => [
                            [
                                'id'        => 20000000,
                                'products'  => [
                                    [
                                        'name'       => 'Product Z',
                                        'amount'     => ['value' => 299.99, 'currency' => Currency::USD->value],
                                        'features'   => [],
                                        'stockBatch' => [100]
                                    ]
                                ],
                                'createdAt' => '2020-01-01T00:00:00-03:00'
                            ]
                        ]
                    ]
                ]
            ],
            'Customer with mixed orders'    => [
                'iterable' => [$customerWithMixedOrders],
                'expected' => [
                    [
                        'id'     => '56789abc-5678-5678-5678-56789abcdef0',
                        'orders' => [
                            [
                                'id'        => 30000000,
                                'products'  => [
                                    [
                                        'name'       => 'Product A',
                                        'amount'     => ['value' => 50.0, 'currency' => Currency::BRL->value],
                                        'features'   => [],
                                        'stockBatch' => []
                                    ]
                                ],
                                'createdAt' => '1997-01-01 01:15:00'
                            ],
                            [
                                'id'        => 30000001,
                                'products'  => [
                                    [
                                        'name'       => 'Product B',
                                        'amount'     => ['value' => 150.75, 'currency' => Currency::EUR->value],
                                        'features'   => [['color' => Color::RED->name]],
                                        'stockBatch' => [5]
                                    ]
                                ],
                                'createdAt' => '1997-01-01T01:15:00-02:00'
                            ],
                            [
                                'id'        => 30000002,
                                'products'  => [
                                    [
                                        'name'       => 'Product C',
                                        'amount'     => ['value' => 99.99, 'currency' => Currency::USD->value],
                                        'features'   => [],
                                        'stockBatch' => [10]
                                    ]
                                ],
                                'createdAt' => '1997-01-01T02:30:00-02:00'
                            ]
                        ]
                    ]
                ]
            ],
            'Customer with multiple orders' => [
                'iterable' => [$customerWithMultipleOrders],
                'expected' => [
                    [
                        'id'     => '88ecb5f8-ef13-4026-a002-9baad15f7a26',
                        'orders' => [
                            [
                                'id'        => 10000000,
                                'products'  => [
                                    [
                                        'name'       => 'Product X',
                                        'amount'     => ['value' => 1099.99, 'currency' => Currency::USD->value],
                                        'features'   => [['color' => Color::RED->name]],
                                        'stockBatch' => [45000]
                                    ],
                                    [
                                        'name'       => 'Product Y',
                                        'amount'     => ['value' => 123.0005, 'currency' => Currency::USD->value],
                                        'features'   => [['color' => Color::BLACK->name]],
                                        'stockBatch' => [3, 6, 9, 12]
                                    ]
                                ],
                                'createdAt' => '2020-01-01T00:00:00-03:00'
                            ],
                            [
                                'id'        => 10000001,
                                'products'  => [
                                    [
                                        'name'       => 'Product X',
                                        'amount'     => ['value' => 6066.55, 'currency' => Currency::BRL->value],
                                        'features'   => [['color' => Color::RED->name]],
                                        'stockBatch' => [45000]
                                    ],
                                    [
                                        'name'       => 'Product Y',
                                        'amount'     => ['value' => 678.36, 'currency' => Currency::BRL->value],
                                        'features'   => [['color' => Color::BLACK->name]],
                                        'stockBatch' => [3, 6, 9, 12]
                                    ]
                                ],
                                'createdAt' => '2020-01-01T00:00:00-03:00'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function discardKeysDataProvider(): array
    {
        return [
            'Mixed types'                  => [
                'iterable' => ['key1' => 'apple', 'key2' => 100, 'key3' => 12.34, 'key4' => true],
                'expected' => ['apple', 100, 12.34, true]
            ],
            'Array of floats'              => [
                'iterable' => ['key1' => 1.5, 'key2' => 2.5, 'key3' => 3.5],
                'expected' => [1.5, 2.5, 3.5]
            ],
            'Array of strings'             => [
                'iterable' => ['key1' => 'apple', 'key2' => 'banana', 'key3' => 'cherry'],
                'expected' => ['apple', 'banana', 'cherry']
            ],
            'Array of integers'            => [
                'iterable' => ['key1' => 10, 'key2' => 20, 'key3' => 30],
                'expected' => [10, 20, 30]
            ],
            'Array of booleans'            => [
                'iterable' => ['key1' => true, 'key2' => false, 'key3' => true],
                'expected' => [true, false, true]
            ],
            'ArrayIterator of mixed types' => [
                'iterable' => new ArrayIterator(['key1' => 'apple', 'key2' => 100, 'key3' => 12.34, 'key4' => true]),
                'expected' => ['apple', 100, 12.34, true]
            ]
        ];
    }

    public static function preserveKeysDataProvider(): array
    {
        return [
            'Mixed types'                  => [
                'iterable' => ['key1' => 'apple', 'key2' => 100, 'key3' => 12.34, 'key4' => true],
                'expected' => ['key1' => 'apple', 'key2' => 100, 'key3' => 12.34, 'key4' => true]
            ],
            'Array of floats'              => [
                'iterable' => ['key1' => 1.5, 'key2' => 2.5, 'key3' => 3.5],
                'expected' => ['key1' => 1.5, 'key2' => 2.5, 'key3' => 3.5]
            ],
            'Array of strings'             => [
                'iterable' => ['key1' => 'apple', 'key2' => 'banana', 'key3' => 'cherry'],
                'expected' => ['key1' => 'apple', 'key2' => 'banana', 'key3' => 'cherry']
            ],
            'Array of integers'            => [
                'iterable' => ['key1' => 10, 'key2' => 20, 'key3' => 30],
                'expected' => ['key1' => 10, 'key2' => 20, 'key3' => 30]
            ],
            'Array of booleans'            => [
                'iterable' => ['key1' => true, 'key2' => false, 'key3' => true],
                'expected' => ['key1' => true, 'key2' => false, 'key3' => true]
            ],
            'ArrayIterator of mixed types' => [
                'iterable' => new ArrayIterator(['key1' => 'apple', 'key2' => 100, 'key3' => 12.34, 'key4' => true]),
                'expected' => ['key1' => 'apple', 'key2' => 100, 'key3' => 12.34, 'key4' => true]
            ]
        ];
    }
}