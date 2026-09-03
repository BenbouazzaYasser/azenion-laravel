<?php

namespace App\Events;

use App\Models\Call;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallDeclined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $call;

    public function __construct(Call $call)
    {
        $this->call = $call;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('conversation.'.$this->call->conversation_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'call_id' => $this->call->id,
        ];
    }
}
