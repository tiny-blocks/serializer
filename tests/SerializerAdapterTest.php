<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TinyBlocks\Serializer\Models\Serializable\Address;
use TinyBlocks\Serializer\Models\Serializable\Addresses;
use TinyBlocks\Serializer\Models\Serializable\Country;
use TinyBlocks\Serializer\Models\Serializable\Shipping;
use TinyBlocks\Serializer\Models\Serializable\State;

final class SerializerAdapterTest extends TestCase
{
    #[DataProvider('shippingDataProviderForArray')]
    public function testSerializeToArray(Shipping $shipping, array $expected): void
    {
        /** @When the toArray method is called on the Shipping object */
        $actual = $shipping->toArray();

        /** @Then the result should match the expected structure */
        self::assertSame($expected, $actual);
    }

    #[DataProvider('shippingDataProviderForJson')]
    public function testSerializeToJson(Shipping $shipping, string $expected): void
    {
        /** @When the toJson method is called on the Shipping object */
        $actual = $shipping->toJson();

        /** @Then the result should match the expected JSON string */
        self::assertJsonStringEqualsJsonString($expected, $actual);
    }

    public static function shippingDataProviderForArray(): array
    {
        $shippingWithNoAddresses = new Shipping(id: 1, addresses: new Addresses());
        $shippingWithSingleAddress = new Shipping(
            id: 2,
            addresses: new Addresses(
                elements: [
                    new Address(
                        city: 'São Paulo',
                        state: State::SP,
                        street: 'Avenida Paulista',
                        number: 100,
                        country: Country::BRAZIL
                    )
                ]
            )
        );
        $shippingWithMultipleAddresses = new Shipping(
            id: 100000,
            addresses: new Addresses(
                elements: [
                    new Address(
                        city: 'New York',
                        state: State::NY,
                        street: '5th Avenue',
                        number: 1,
                        country: Country::UNITED_STATES
                    ),
                    new Address(
                        city: 'New York',
                        state: State::NY,
                        street: 'Broadway',
                        number: 42,
                        country: Country::UNITED_STATES
                    )
                ]
            )
        );

        return [
            'Shipping object with no addresses'       => [
                'shipping' => $shippingWithNoAddresses,
                'expected' => ['id' => 1, 'addresses' => []]
            ],
            'Shipping object with a single address'   => [
                'shipping' => $shippingWithSingleAddress,
                'expected' => [
                    'id'        => 2,
                    'addresses' => [
                        [
                            'city'    => 'São Paulo',
                            'state'   => State::SP->name,
                            'street'  => 'Avenida Paulista',
                            'number'  => 100,
                            'country' => Country::BRAZIL->value
                        ]
                    ]
                ]
            ],
            'Shipping object with multiple addresses' => [
                'shipping' => $shippingWithMultipleAddresses,
                'expected' => [
                    'id'        => 100000,
                    'addresses' => [
                        [
                            'city'    => 'New York',
                            'state'   => State::NY->name,
                            'street'  => '5th Avenue',
                            'number'  => 1,
                            'country' => Country::UNITED_STATES->value
                        ],
                        [
                            'city'    => 'New York',
                            'state'   => State::NY->name,
                            'street'  => 'Broadway',
                            'number'  => 42,
                            'country' => Country::UNITED_STATES->value
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function shippingDataProviderForJson(): array
    {
        return [
            'Shipping object with no addresses'       => [
                'shipping' => new Shipping(id: 1, addresses: new Addresses()),
                'expected' => '{"id":1,"addresses":[]}'
            ],
            'Shipping object with a single address'   => [
                'shipping' => new Shipping(
                    id: 2,
                    addresses: new Addresses(
                        elements: [
                            new Address(
                                city: 'São Paulo',
                                state: State::SP,
                                street: 'Avenida Paulista',
                                number: 100,
                                country: Country::BRAZIL
                            )
                        ]
                    )
                ),
                'expected' => '{"id":2,"addresses":[{"city":"São Paulo","state":"SP","street":"Avenida Paulista","number":100,"country":"BR"}]}'
            ],
            'Shipping object with multiple addresses' => [
                'shipping' => new Shipping(
                    id: 100000,
                    addresses: new Addresses(
                        elements: [
                            new Address(
                                city: 'New York',
                                state: State::NY,
                                street: '5th Avenue',
                                number: 1,
                                country: Country::UNITED_STATES
                            ),
                            new Address(
                                city: 'New York',
                                state: State::NY,
                                street: 'Broadway',
                                number: 42,
                                country: Country::UNITED_STATES
                            )
                        ]
                    )
                ),
                'expected' => '{"id":100000,"addresses":[{"city":"New York","state":"NY","street":"5th Avenue","number":1,"country":"US"},{"city":"New York","state":"NY","street":"Broadway","number":42,"country":"US"}]}'
            ]
        ];
    }
}
