<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function home_page_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Liste des Tâches');
    }

    /** @test */
    public function user_can_create_a_task()
    {
        $response = $this->post('/tasks', [
            'title' => 'Nouvelle tâche',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['title' => 'Nouvelle tâche']);
    }

    /** @test */
    public function task_title_is_required()
    {
        $response = $this->post('/tasks', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function user_can_delete_a_task()
    {
        $task = Task::create(['title' => 'À supprimer']);

        $response = $this->delete('/tasks/' . $task->id);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function user_can_mark_task_as_completed()
    {
        $task = Task::create(['title' => 'À compléter', 'completed' => false]);

        $response = $this->patch('/tasks/' . $task->id . '/complete');

        $response->assertRedirect('/tasks');
        $this->assertTrue($task->fresh()->completed);
    }

    /** @test */
    public function task_list_displays_all_tasks()
    {
        Task::create(['title' => 'Tâche 1']);
        Task::create(['title' => 'Tâche 2']);

        $response = $this->get('/');
        $response->assertSee('Tâche 1');
        $response->assertSee('Tâche 2');
    }
}
