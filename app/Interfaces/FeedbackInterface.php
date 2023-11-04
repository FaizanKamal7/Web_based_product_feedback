<?php

namespace App\Interfaces;

interface FeedbackInterface
{
    public function createFeedback($data);
    public function createFeedbackComment($data);
    public function createFeedbackVote($data);
    public function createFeedbackCommentReaction($data);
}
