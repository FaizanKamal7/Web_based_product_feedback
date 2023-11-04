<?php

namespace App\Repositories;

use App\Interfaces\FeedbackInterface;
use App\Models\Feedback;
use App\Models\FeedbackComment;
use App\Models\FeedbackCommentReaction;
use App\Models\FeedbackVote;

class FeedbackRepository implements FeedbackInterface
{
    public function createFeedback($data)
    {
        return Feedback::create($data);
    }

    public function createFeedbackComment($data)
    {
        return FeedbackComment::create($data);
    }

    public function createFeedbackVote($data)
    {
        return FeedbackVote::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'feedback_id' => $data['feedback_id'],
            ],
            [
                'vote_type' => $data['vote_type'],
            ]
        );
    }

    public function createFeedbackCommentReaction($data)
    {
        // Check if a reaction already exists for the given user and comment
        $reaction = FeedbackCommentReaction::where([
            'user_id' => $data['user_id'],
            'feedback_comment_id' => $data['comment_id'],
            'reaction' => $data['reaction'],
        ])->first();

        if ($reaction) {
            // If a reaction exists, delete it
            $reaction->delete();

            // You may want to return some indicator that a deletion occurred
            return ['status' => 'deleted'];
        } else {
            // If no reaction exists, create a new one
            return FeedbackCommentReaction::create([
                'user_id' => $data['user_id'],
                'feedback_comment_id' => $data['comment_id'],
                'reaction' => $data['reaction'],
            ]);
        }
    }
}
