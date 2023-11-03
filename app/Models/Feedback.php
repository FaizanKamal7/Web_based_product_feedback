<?php

namespace App\Models;

use App\Enums\VoteTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'feedback_category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function feedbackCategory()
    {
        return $this->belongsTo(FeedbackCategory::class, 'feedback_category_id');
    }

    public function feedbackComments()
    {
        return $this->hasMany(FeedbackComment::class);
    }

    public function feedbackVotes()
    {
        return $this->hasMany(FeedbackVote::class);
    }

    public function feedbackUpVotes()
    {
        return $this->feedbackVotes()->where('vote_type',  VoteTypeEnum::UP_VOTE->value);
    }

    public function feedbackDownVotes()
    {
        return $this->feedbackVotes()->where('vote_type',  VoteTypeEnum::DOWN_VOTE->value);
    }
}
