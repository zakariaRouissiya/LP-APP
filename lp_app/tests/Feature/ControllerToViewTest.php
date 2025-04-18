<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControllerToViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_displays_all_tasks()
    {
        $task = Task::create(['title' => 'Test task']);

        $response = $this->get('/tasks');

        $response->assertViewHas('tasks', function ($tasks) use ($task) {
            return $tasks->contains($task);
        });
    }
}
