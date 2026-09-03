<?php

namespace App\Http\Controllers;

use App\Events\ChannelMessageSent;
use App\Models\Channel;
use App\Models\ChannelMessage;
use App\Models\Server;
use App\Models\ServerMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::with(['owner.profile', 'channels'])->withCount('members')->get();

        return view('sections.servers', compact('servers'));
    }

    public function show(Request $request, $id)
    {
        $server = Server::with(['owner.profile', 'channels', 'members.user.profile'])->findOrFail($id);

        $channelId = $request->input('channel', $server->channels->first()?->id);
        $currentChannel = $server->channels->where('id', $channelId)->first() ?? $server->channels->first();

        if ($currentChannel) {
            $currentChannel->load(['messages.user.profile']);
        }

        return view('sections.server-detail', compact('server', 'currentChannel'));
    }

    public function storeMessage(Request $request, Server $server, Channel $channel)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        if ($channel->server_id !== $server->id) {
            abort(404);
        }

        if ($server->owner_id !== auth()->id() && ! $server->members()->where('user_id', auth()->id())->exists()) {
            abort(403, 'You must join this server to send messages.');
        }

        $message = ChannelMessage::create([
            'channel_id' => $channel->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        $message->load('user.profile');

        // Broadcast the message to other members
        broadcast(new ChannelMessageSent($message))->toOthers();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'content' => $message->content,
                    'user_name' => $message->user->profile->full_name ?? $message->user->name,
                    'is_me' => true,
                ],
            ]);
        }

        return redirect()->route('servers.show', [$server->id, 'channel' => $channel->id])->with('success', 'Message sent.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
        ]);

        $server = Server::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::random(5),
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'] ?? 'general',
            'owner_id' => auth()->id(),
        ]);

        ServerMember::create([
            'server_id' => $server->id,
            'user_id' => auth()->id(),
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        Channel::create([
            'server_id' => $server->id,
            'name' => 'general',
            'type' => 'text',
            'description' => 'General discussion channel',
        ]);

        return redirect()->route('servers')->with('success', 'Server created successfully!');
    }

    public function join(Request $request, Server $server)
    {
        if ($server->members()->where('user_id', auth()->id())->exists()) {
            return back()->with('info', 'You are already a member of this server.');
        }

        ServerMember::create([
            'server_id' => $server->id,
            'user_id' => auth()->id(),
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return back()->with('success', 'Successfully joined server!');
    }

    public function leave(Request $request, Server $server)
    {
        if ($server->owner_id === auth()->id()) {
            return back()->with('error', 'Server owners cannot leave their own server.');
        }

        $server->members()->where('user_id', auth()->id())->delete();

        return back()->with('success', 'Successfully left server.');
    }
}
