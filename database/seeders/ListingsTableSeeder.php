<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Seeder;

class ListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Listing::create([
            'user_id' => 1,
            'status' => 'active',
            'description' => 'Beautiful 3-bedroom house with a spacious backyard',
            'price' => 250000.00,
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'NY',
            'zip' => '12345',
            'photo' => 'house1.jpg',
            'category_id' => 1,
            'type' => 'sale',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'sqft' => 1800.00,
            'lot_size' => 0.25,
            'year_built' => 2000,
            'parking' => 2,
        ]);

        Listing::create([
            'user_id' => 1,
            'status' => 'active',
            'description' => 'Modern condo with city views in a prime location',
            'price' => 150000.00,
            'address' => '456 Elm St',
            'city' => 'Otherville',
            'state' => 'CA',
            'zip' => '54321',
            'photo' => 'condo1.jpg',
            'category_id' => 2,
            'type' => 'sale',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'sqft' => 1000.00,
            'lot_size' => 0.1,
            'year_built' => 2010,
            'parking' => 1,
        ]);
    }
}
