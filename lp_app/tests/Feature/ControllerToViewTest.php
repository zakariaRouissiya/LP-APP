<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Category;

class ControllerToViewTest extends TestCase
{
    /**
     * Teste si les tâches sont correctement transmises à la vue.
     *
     * @return void
     */
    public function test_tasks_are_passed_to_view()
    {
        $task = Task::factory()->create();

        $response = $this->get('/tasks');
        $response->assertStatus(200);
        $response->assertSee($task->title);
    }

    /**
     * Teste si les catégories sont correctement transmises à la vue.
     *
     * @return void
     */
    public function test_categories_are_passed_to_view()
    {
        $category = Category::factory()->create();

        $response = $this->get('/tasks');
        $response->assertStatus(200);
        $response->assertSee($category->name);
    }
}
