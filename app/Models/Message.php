<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $guarded = [];

    protected $casts = [
        'call_data' => 'array',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function isVoice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type === 'voice',
        );
    }

    public function isCallLog(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type === 'call_log',
        );
    }
}
