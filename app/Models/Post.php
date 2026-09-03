<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    protected $guarded = [];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(UpdateLike::class, 'target')->where('target_type', 'post');
    }

    public function saves(): MorphMany
    {
        return $this->morphMany(UpdateLike::class, 'target')->where('target_type', 'post_save');
    }
}
