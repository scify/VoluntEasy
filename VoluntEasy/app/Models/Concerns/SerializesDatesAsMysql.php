<?php

namespace App\Models\Concerns;

use DateTimeInterface;

/**
 * Keep the "Y-m-d H:i:s" date format in JSON/array output (Laravel 5 format).
 * The front-end JavaScript reads dates in this format.
 */
trait SerializesDatesAsMysql
{
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
