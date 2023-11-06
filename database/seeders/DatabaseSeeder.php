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
    public function run()
    {

        // ------ Adding Permission
        $this->command->warn(PHP_EOL . 'Importing Permissions...');
        $this->call(PermissionSeeder::class);
        $this->command->info('Permission added.');

        // ------ Adding Feedback Categories 
        $this->command->warn(PHP_EOL . 'Importing Feedback Categories...');
        $this->call(FeedbackCategorySeeder::class);
        $this->command->info('Feedback Categories added.');


        // ------ Adding Users 
        $this->command->warn(PHP_EOL . 'Importing users...');
        $this->call(UserSeeder::class);
        $this->command->info('Users added.');

        $this->command->info('For demonstration purposes only');
        $this->command->error('Admin Credentials');
        $this->command->comment('Email: admin@ikonic.com');
        $this->command->comment('Password: password');
        $this->command->line('');

        $this->command->error('Normal User Credentials');
        $this->command->comment('Email: test@ikonic.com');
        $this->command->comment('Password: password');


        // You can call other seeders here if needed, or seed some data directly.

        // // Seed the feedback categories
        // FeedbackCategory::factory(5)->create()->each(function ($feedback_category) {
        //     $feedback_category->feedback()->saveMany(Feedback::factory(rand(1, 3))->create());
        // });

        // // Seed the users, and within each user, seed their feedbacks, comments, votes, and reactions
        // User::factory(10)->create()->each(function ($user) {

        //     // Seed the feedbacks for each user
        //     $user->feedbacks()->saveMany(Feedback::factory(rand(1, 5))->make())
        //         ->each(function ($feedback) {

        //             // Seed the comments for each feedback
        //             $feedback->comments()->saveMany(FeedbackComment::factory(rand(1, 10))->make())
        //                 ->each(function ($comment) {

        //                     // Seed the reactions for each comment
        //                     $comment->reactions()->saveMany(FeedbackCommentReaction::factory(rand(1, 3))->make());
        //                 });

        //             // Seed the votes for each feedback
        //             $feedback->votes()->saveMany(FeedbackVote::factory(rand(1, 20))->make());
        //         });
        // });
    }
}
