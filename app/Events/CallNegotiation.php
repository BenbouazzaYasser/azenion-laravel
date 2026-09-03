<?php

namespace App\Events;

use App\Models\Call;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallNegotiation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $call;

    public $offer;

    public $fromUserId;

    public function __construct(Call $call, $offer, $fromUserId)
    {
        $this->call = $call;
        $this->offer = $offer;
        $this->fromUserId = $fromUserId;
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
            'offer' => $this->offer,
            'from_user_id' => $this->fromUserId,
        ];
    }
}
