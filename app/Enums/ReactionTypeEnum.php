<?php

namespace App\Enums;

enum ReactionTypeEnum: string
{
    case LIKE = 'like';
    case DISLIKE = 'dislike';
    case SMILE = 'smile';
    case SAD = 'sad';
    case HEART = 'heart';
    case ANGRY = 'angry';
}
