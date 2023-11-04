<?php

namespace Database\Factories;

use App\Enums\ReactionTypeEnum;
use App\Models\FeedbackCommentReaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackCommentReaction>
 */
class FeedbackCommentReactionFactory extends Factory
{
    protected $model = FeedbackCommentReaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reaction' => $this->faker->randomElement([
                ReactionTypeEnum::LIKE->value,
                ReactionTypeEnum::DISLIKE->value,
                ReactionTypeEnum::SMILE->value,
                ReactionTypeEnum::SAD->value,
                ReactionTypeEnum::HEART->value,
            ]),
        ];
    }
}
