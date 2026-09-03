<?php

namespace App\Events;

use App\Models\Call;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallAnswered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $call;

    public $answer;

    public function __construct(Call $call, $answer)
    {
        $this->call = $call;
        $this->answer = $answer;
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
            'answer' => $this->answer,
        ];
    }
}
