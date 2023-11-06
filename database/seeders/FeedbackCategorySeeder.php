<?php

namespace Database\Seeders;

use App\Models\FeedbackCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedbackCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeedbackCategory::create(['name' => 'Bug Report']);
        FeedbackCategory::create(['name' => 'Feature Request']);
        FeedbackCategory::create(['name' => 'Improvement']);
    }
}
