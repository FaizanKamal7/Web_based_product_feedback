<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackComment;
use App\Models\FeedbackCommentReaction;
use App\Models\FeedbackVote;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        FeedbackCategory::factory()->specificNames()->times(3)->create();
        User::factory()
            ->count(10) // Change the number as needed
            ->has(
                Feedback::factory()
                    ->count(5) // Number of feedbacks per user
                    ->has(
                        FeedbackComment::factory()
                            ->count(3) // Number of comments per feedback
                            ->has(
                                FeedbackCommentReaction::factory()
                                    ->count(2) // Number of reactions per comment
                            )
                    )
                    ->has(
                        FeedbackVote::factory()
                            ->count(3) // Number of votes per feedback
                    )

            )
            ->create();
    }
}
