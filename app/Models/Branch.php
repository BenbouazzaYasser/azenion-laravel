<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $guarded = [];

    public function members(): HasMany
    {
        return $this->hasMany(BranchMember::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'branch_members', 'branch_id', 'user_id')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }
}
