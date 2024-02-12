<?php

namespace TinyBlocks\Serializer\Mock;

final readonly class TransactionMock
{
    public function __construct(private int $id, private AmountMock $amount)
    {
    }
}
