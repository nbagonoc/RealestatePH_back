<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::create([
            'user_id' => 2,
            'profile_id' => 1,
            'rate' => 5,
            'review' => 'Agent was able to answer all my inquiries, and exceeded my expectations!'
        ]);
    }
}
