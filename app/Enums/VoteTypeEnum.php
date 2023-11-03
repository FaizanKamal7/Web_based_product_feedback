<?php

namespace App\Enums;

enum VoteTypeEnum: string
{
    case UP_VOTE = 'upvote';
    case DOWN_VOTE = 'downvote';
}
