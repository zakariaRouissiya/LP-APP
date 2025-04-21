<?php

namespace Tests\Feature;

use Tests\TestCase;

class PingTest extends TestCase
{
    /**
     * Teste si les routes principales sont accessibles.
     *
     * @return void
     */
    public function test_home_page_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_tasks_page_is_accessible()
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }
}
