<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Server extends Model
{
    protected $guarded = [];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(ServerMember::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'server_members', 'server_id', 'user_id')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }
}
