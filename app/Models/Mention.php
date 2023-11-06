<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['user_id'];

    public function mentionable()
    {
        return $this->morphTo();
    }
}
