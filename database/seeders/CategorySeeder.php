<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Arabika',       'slug' => 'arabika',       'is_active' => true],
            ['name' => 'Robusta',       'slug' => 'robusta',       'is_active' => true],
            ['name' => 'Blend',         'slug' => 'blend',         'is_active' => true],
            ['name' => 'Single Origin', 'slug' => 'single-origin', 'is_active' => true],
            ['name' => 'Decaf',         'slug' => 'decaf',         'is_active' => true],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
