<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TaskUITest extends DuskTestCase
{
    /**
     * Teste si la page des tâches est accessible.
     *
     * @return void
     */
    public function test_tasks_page_is_accessible()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                    ->pause(1000) 
                    ->assertSee('Liste des Tâches');
        });
    }

    /**
     * Teste si les tâches sont affichées dans le tableau.
     *
     * @return void
     */
    public function test_tasks_are_displayed_in_table()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                    ->pause(1000) 
                    ->assertSee('Titre') 
                    ->assertSee('Catégorie') 
                    ->assertSee('Priorité'); 
        });
    }

    /**
     * Teste le filtrage par catégorie.
     *
     * @return void
     */
    public function test_filter_by_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                    ->select('category', '1') 
                    ->press('Filtrer')
                    ->pause(1000)
                    ->assertSee('Travail')
                    ->assertDontSee('Catégorie 2');
        });
    }

}
