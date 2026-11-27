<?php

namespace Tests\Unit;

use App\Services\TaskService;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    /** @return array<string, array{list<int>, string|null}> */
    public static function subtaskStatuses(): array
    {
        // 1 = to do, 2 = doing, 3 = done
        return [
            'no subtasks' => [[], null],
            'all to do' => [[1, 1], 'todo'],
            'one in progress' => [[1, 2, 3], 'doing'],
            'all done' => [[3, 3], 'done'],
            'some to do, some done' => [[1, 3], 'todo'],
        ];
    }

    /** @param list<int> $statuses */
    #[DataProvider('subtaskStatuses')]
    public function test_the_task_status_follows_its_subtasks(array $statuses, ?string $expected): void
    {
        $task = (object) ['subtasks' => array_map(fn (int $status) => (object) ['status_id' => $status], $statuses)];

        $this->assertSame($expected, (new TaskService)->taskStatus($task));
    }
}
