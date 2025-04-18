<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AddTaskTest extends DuskTestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_add_a_task_via_interface()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                ->pause(2000)
                ->assertSee("Liste des Tâches")
                ->click('.btn-custom')
                ->pause(1000)
                ->type('#title', 'Tâche Dusk')
                ->press('Ajouter')
                ->waitForText('Tâche Dusk', 5)
                ->assertSee('Tâche Dusk');
        });
    }
}
