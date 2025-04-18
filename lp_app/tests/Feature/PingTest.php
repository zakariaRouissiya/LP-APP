<?php

namespace Tests\Feature;

use Tests\TestCase;

class PingTest extends TestCase
{
    /** @test */
    public function home_page_is_accessible()
    {
        $this->get('/tasks')->assertStatus(200);
    }

    /** @test */
    public function create_task_page_is_accessible()
    {
        $this->get('/tasks/create')->assertStatus(200);
    }
}
