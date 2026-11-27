<?php

namespace Tests\Unit;

use App\Models\ActionTasks\SubtaskShift;
use App\Models\ActionTasks\TaskShift;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ShiftWorkingHoursTest extends TestCase
{
    /** @return array<string, array{string, string, float|int}> */
    public static function shifts(): array
    {
        return [
            'day shift' => ['10:00:00', '14:00:00', 4],
            'half hour' => ['09:00:00', '09:30:00', 0.5],
            'ends at midnight' => ['21:00:00', '00:00:00', 3],
            'overnight' => ['23:00:00', '02:00:00', 3],
        ];
    }

    #[DataProvider('shifts')]
    public function test_working_hours(string $from, string $to, float|int $hours): void
    {
        foreach ([new TaskShift, new SubtaskShift] as $shift) {
            $shift->setRawAttributes(['from_hour' => $from, 'to_hour' => $to], true);

            $this->assertEquals($hours, $shift->workingHours());
        }
    }
}
