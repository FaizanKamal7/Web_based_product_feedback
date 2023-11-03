<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCommentReaction extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'reaction',
        'user_id',
        'feedback_comment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function feedbackComment()
    {
        return $this->belongsTo(FeedbackComment::class, 'feedback_comment_id');
    }
}
