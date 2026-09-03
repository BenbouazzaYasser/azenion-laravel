<?php

namespace App\Events;

use App\Models\Call;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallInitiated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $call;

    public $callerId;

    public $receiverId;

    public $offer;

    public $type;

    public function __construct(Call $call, $offer, $type = 'voice')
    {
        $this->call = $call;
        $this->callerId = $call->caller_id;
        $this->receiverId = $call->receiver_id;
        $this->offer = $offer;
        $this->type = $type;
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
            'caller_id' => $this->callerId,
            'receiver_id' => $this->receiverId,
            'offer' => $this->offer,
            'type' => $this->type,
        ];
    }
}
