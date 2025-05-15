<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_created()
    {
        $task = Task::factory()->create([
            'title' => 'Test Task',
            'priority' => 'moyenne',
            'completed' => false,
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'priority' => 'moyenne',
            'completed' => false,
        ]);
    }
}
