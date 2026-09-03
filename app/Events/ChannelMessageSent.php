<?php

namespace App\Events;

use App\Models\ChannelMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChannelMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $channelId;

    public $serverId;

    public function __construct(ChannelMessage $message)
    {
        $this->message = $message;
        $this->channelId = $message->channel_id;
        $this->serverId = $message->channel->server_id;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('server.'.$this->serverId.'.channel.'.$this->channelId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'content' => $this->message->content,
            'user_id' => $this->message->user_id,
            'user_name' => $this->message->user->profile->full_name ?? $this->message->user->name,
            'channel_id' => $this->message->channel_id,
            'server_id' => $this->serverId,
            'created_at' => $this->message->created_at?->toISOString(),
        ];
    }
}
