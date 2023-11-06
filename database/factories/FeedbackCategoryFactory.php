<?php

namespace Database\Factories;

use App\Models\FeedbackCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackCategory>
 */
class FeedbackCategoryFactory extends Factory
{
    public function definition()
    {
        // Define other attributes with dynamic or random values here
        return [
            'name' => $this->faker->name, // Example of a dynamic attribute
        ];
    }

    // Define a state to create only three records with specific names
    public function specificNames()
    {
        static $index = 0;

        $names = ['Bug Report', 'Feature Request', 'Improvement'];
        $name = $names[$index % count($names)];
        $index++;

        return $this->state(function (array $attributes) use ($name) {
            return ['name' => $name];
        });
    }
}
