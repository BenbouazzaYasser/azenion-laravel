<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lab extends Model
{
    protected $table = 'labs';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'test_cases' => 'array',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(LabSubmission::class);
    }
}
