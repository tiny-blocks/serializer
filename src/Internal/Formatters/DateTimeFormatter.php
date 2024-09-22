<?php

declare(strict_types=1);

namespace TinyBlocks\Serializer\Internal\Formatters;

use DateTimeImmutable;
use DateTimeInterface;

final class DateTimeFormatter
{
    public function format(DateTimeImmutable $date): string
    {
        if ($date->getTimezone()->getOffset($date) !== 0) {
            return $date->format(DateTimeInterface::ATOM);
        }

        return $date->format('Y-m-d H:i:s');
    }
}
