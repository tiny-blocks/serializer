# Serializer

[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

* [Overview](#overview)
* [Installation](#installation)
* [How to use](#how-to-use)
* [License](#license)
* [Contributing](#contributing)

<div id='overview'></div> 

## Overview

Handles serialization and deserialization of data structures, in array and JSON structures.

<div id='installation'></div>

## Installation

```bash
composer require tiny-blocks/serializer
```

<div id='how-to-use'></div>

## How to use

The library exposes available behaviors through the `Serializer` interface, and the implementation of these behaviors
through the `SerializerAdapter` trait.

### Concrete implementation

```php
<?php

namespace Example;

use TinyBlocks\Serializer\Serializer;
use TinyBlocks\Serializer\SerializerAdapter;

final class Amount implements Serializer
{
    use SerializerAdapter;

    public function __construct(private readonly float $value, private readonly string $currency)
    {
    }
}
```

### Using the toJson method

The `toJson` method returns the representation of the object in **JSON** format.

```php
$amount = new Amount(value: 1.25, currency: 'USD');

$amount->toJson(); # {"value":1.25,"currency":"USD"}
```

### Using the toArray method

The `toArray` method returns the representation of the object in **array** format.

```php
$amount = new Amount(value: 1.25, currency: 'USD');

$amount->toArray(); # Array
                    # (
                    #     [value] => 1.25
                    #     [currency] => USD
                    # )
```

<div id='license'></div>

## License

Serializer is licensed under [MIT](LICENSE).

<div id='contributing'></div>

## Contributing

Please follow the [contributing guidelines](https://github.com/tiny-blocks/tiny-blocks/blob/main/CONTRIBUTING.md) to
contribute to the project.
