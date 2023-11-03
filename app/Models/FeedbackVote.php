<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackVote extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'vote_type',
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
}
