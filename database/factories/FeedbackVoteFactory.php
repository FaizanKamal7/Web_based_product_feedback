<?php

namespace Database\Factories;

use App\Enums\VoteTypeEnum;
use App\Models\FeedbackVote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackVote>
 */
class FeedbackVoteFactory extends Factory
{
    protected $model = FeedbackVote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reaction' => $this->faker->randomElement([
                VoteTypeEnum::DOWN_VOTE->value,
                VoteTypeEnum::UP_VOTE->value,
            ]),
        ];
    }
}
