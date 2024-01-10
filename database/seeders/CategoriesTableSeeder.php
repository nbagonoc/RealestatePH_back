<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::create([
        //     'name' => 'house',
        // ]);

        // Category::create([
        //     'name' => 'condo',
        // ]);

        // Category::create([
        //     'name' => 'townhouse',
        // ]);

        // Category::create([
        //     'name' => 'apartment',
        // ]);

        // Category::create([
        //     'name' => 'land',
        // ]);

        // Category::create([
        //     'name' => 'commercial',
        // ]);

        $categories = [
            'house',
            'condo',
            'townhouse',
            'apartment',
            'land',
            'commercial',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
