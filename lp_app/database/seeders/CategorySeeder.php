<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Travail',
            'Personnel',
            'Urgent',
            'Études',
            'Maison',
            'Santé',
            'Loisirs',
            'Voyage',
            'Finances',
            'Projets',
            'Courses',
            'Famille',
            'Sport',
            'Lecture',
            'Autres',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
