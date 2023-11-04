<?php

namespace App\Models;

use App\Enums\ReactionTypeEnum;
use Database\Factories\FeedbackCommentFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackComment extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'content',
        'user_id',
        'feedback_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'feedback_id');
    }

    public function feedbackCommentReaction()
    {
        return $this->hasMany(FeedbackCommentReaction::class);
    }

    public function feedbackCommentLikes()
    {
        return $this->feedbackCommentReaction()->where('reaction',  ReactionTypeEnum::LIKE->value);
    }

    public function feedbackCommentDislikes()
    {
        return $this->feedbackCommentReaction()->where('reaction',  ReactionTypeEnum::DISLIKE->value);
    }

    public function feedbackCommentHearts()
    {
        return $this->feedbackCommentReaction()->where('reaction',  ReactionTypeEnum::HEART->value);
    }

    public function feedbackCommentSmile()
    {
        return $this->feedbackCommentReaction()->where('reaction',  ReactionTypeEnum::SMILE->value);
    }

    public function feedbackCommentSad()
    {
        return $this->feedbackCommentReaction()->where('reaction',  ReactionTypeEnum::SAD->value);
    }

    public function feedbackCommentAngry()
    {
        return $this->feedbackCommentReaction()->where('reaction',  ReactionTypeEnum::ANGRY->value);
    }

    protected static function newFactory()
    {
        return FeedbackCommentFactory::new();
    }
}
