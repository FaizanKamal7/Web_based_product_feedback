<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\FeedbackCommentReactionFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function feedbackComments()
    {
        return $this->hasMany(FeedbackComment::class);
    }

    public function feedbackVotes()
    {
        return $this->hasMany(FeedbackVote::class);
    }

    public function feedbackCommentReactions()
    {
        return $this->hasMany(FeedbackCommentReaction::class);
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
