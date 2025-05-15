<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_page_shows_tasks()
    {
        $task = Task::factory()->create(['title' => 'Task for Testing']);

        $response = $this->get('/tasks');

        $response->assertStatus(200);
        $response->assertSeeText('Task for Testing');
    }
}
