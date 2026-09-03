<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $conversationId;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->conversationId = $message->conversation_id;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('conversation.'.$this->conversationId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'content' => $this->message->content,
            'type' => $this->message->type ?? 'text',
            'audio_url' => $this->message->audio_url,
            'duration' => $this->message->duration,
            'call_data' => $this->message->call_data,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->profile->full_name ?? $this->message->sender->name,
            'conversation_id' => $this->message->conversation_id,
            'created_at' => $this->message->created_at?->toISOString(),
        ];
    }
}
