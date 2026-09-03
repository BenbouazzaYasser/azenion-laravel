<?php

use App\Models\Conversation;
use App\Models\Server;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Private conversation channel - only participants can listen
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    return Conversation::where('id', $conversationId)
        ->whereHas('users', fn ($q) => $q->where('user_id', $user->id))
        ->exists();
});

// Server channel - only server members can listen
Broadcast::channel('server.{serverId}.channel.{channelId}', function ($user, $serverId, $channelId) {
    return Server::where('id', $serverId)
        ->where(function ($q) use ($user) {
            $q->where('owner_id', $user->id)
                ->orWhereHas('members', fn ($mq) => $mq->where('user_id', $user->id));
        })
        ->exists();
});
