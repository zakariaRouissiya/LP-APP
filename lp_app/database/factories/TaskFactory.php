<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Définir les données fictives pour le modèle Task.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'category_id' => null,
            'priority' => $this->faker->randomElement(['faible', 'moyenne', 'élevée']),
            'completed' => $this->faker->boolean,
            'completed_at' => $this->faker->optional()->dateTime,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
