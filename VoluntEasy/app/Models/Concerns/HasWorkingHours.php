<?php

namespace App\Models\Concerns;

/**
 * A shift (of a task or a subtask) from "from_hour" to "to_hour".
 */
trait HasWorkingHours
{
    /**
     * The length of the shift in hours. A shift that ends at or before its
     * start time ends on the next day (for example 21:00-00:00 is 3 hours).
     */
    public function workingHours(): float|int
    {
        $from = strtotime((string) $this->getRawOriginal('from_hour'));
        $to = strtotime((string) $this->getRawOriginal('to_hour'));
        if ($from === false || $to === false) {
            return 0;
        }

        $seconds = $to - $from;
        if ($seconds <= 0) {
            $seconds += 24 * 3600;
        }

        return $seconds / 3600;
    }
}
