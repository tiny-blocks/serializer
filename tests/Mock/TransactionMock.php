<?php

namespace TinyBlocks\Serializer\Mock;

final class TransactionMock
{
    public function __construct(private readonly int $id, private readonly AmountMock $amount)
    {
    }
}
