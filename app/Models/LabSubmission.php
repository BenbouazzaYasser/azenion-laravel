<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabSubmission extends Model
{
    protected $table = 'lab_submissions';

    protected $guarded = [];

    public function lab(): BelongsTo
    {
        return $this->belongsTo(Lab::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
