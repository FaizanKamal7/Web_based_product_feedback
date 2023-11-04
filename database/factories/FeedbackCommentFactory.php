<?php

namespace Database\Factories;

use App\Models\FeedbackComment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackComment>
 */
class FeedbackCommentFactory extends Factory
{
    protected $model = FeedbackComment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->realText($maxNbChars = 200, $indexSize = 2),
        ];
    }
}
