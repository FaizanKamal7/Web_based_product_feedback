<?php

namespace App\Models;

use Database\Factories\FeedbackCategoryFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
    ];

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    protected static function newFactory()
    {
        return FeedbackCategoryFactory::new();
    }
}
