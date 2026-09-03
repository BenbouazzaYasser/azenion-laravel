<?php

namespace App\Http\Controllers;

use App\Events\CallAnswered;
use App\Events\CallDeclined;
use App\Events\CallEnded;
use App\Events\CallICECandidate;
use App\Events\CallInitiated;
use App\Events\CallNegotiation;
use App\Events\MessageSent;
use App\Models\Call;
use App\Models\Conversation;
use App\Models\ConversationMember;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $conversations = $user->conversations()->with(['users.profile', 'messages' => fn ($q) => $q->latest()->limit(1)])->get();

        $search = $request->input('search');
        $users = collect();
        if ($search) {
            $users = User::where('id', '!=', $user->id)
                ->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhereHas('profile', function ($pq) use ($search) {
                            $pq->where('full_name', 'like', "%{$search}%");
                        });
                })
                ->with('profile')
                ->limit(10)
                ->get();
        }

        return view('sections.chat', compact('conversations', 'users', 'search'));
    }

    public function show(Request $request, Conversation $conversation)
    {
        $user = auth()->user();
        if (! $conversation->users()->where('user_id', $user->id)->exists()) {
            abort(403);
        }

        $conversations = $user->conversations()->with(['users.profile', 'messages' => fn ($q) => $q->latest()->limit(1)])->get();

        $search = $request->input('search');
        $users = collect();
        if ($search) {
            $users = User::where('id', '!=', $user->id)
                ->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhereHas('profile', function ($pq) use ($search) {
                            $pq->where('full_name', 'like', "%{$search}%");
                        });
                })
                ->with('profile')
                ->limit(10)
                ->get();
        }

        $conversation->load(['users.profile', 'messages.sender.profile']);

        // Mark as read
        $conversation->members()->where('user_id', $user->id)->update(['last_read_at' => now()]);

        return view('sections.chat', compact('conversations', 'conversation', 'users', 'search'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'image_url' => 'nullable|string',
        ]);

        $user = auth()->user();
        if (! $conversation->users()->where('user_id', $user->id)->exists()) {
            abort(403);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'content' => $validated['content'],
            'image_url' => $validated['image_url'] ?? null,
        ]);

        $message->load('sender.profile');

        // Broadcast the message to other participants
        broadcast(new MessageSent($message))->toOthers();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'content' => $message->content,
                    'sender_name' => $message->sender->profile->full_name ?? $message->sender->name,
                    'is_me' => true,
                ],
            ]);
        }

        return back()->with('success', 'Message sent.');
    }

    public function storeVoice(Request $request, Conversation $conversation)
    {
        $validated = $request->validate([
            'audio' => 'required|file|max:10240',
            'duration' => 'required|integer|min:0|max:300',
        ]);

        $user = auth()->user();
        if (! $conversation->users()->where('user_id', $user->id)->exists()) {
            abort(403);
        }

        $file = $request->file('audio');
        $extension = $file->getClientOriginalExtension() ?: 'webm';
        $filename = 'voice-'.uniqid().'.'.$extension;
        $path = $file->storeAs('voice-messages', $filename, 'public');
        $url = Storage::url($path);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'content' => '',
            'type' => 'voice',
            'audio_url' => $url,
            'duration' => $validated['duration'],
        ]);

        $message->load('sender.profile');

        broadcast(new MessageSent($message))->toOthers();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'type' => 'voice',
                    'audio_url' => $message->audio_url,
                    'duration' => $message->duration,
                    'sender_name' => $message->sender->profile->full_name ?? $message->sender->name,
                    'is_me' => true,
                ],
            ]);
        }

        return back();
    }

    // Call methods
    public function initiateCall(Request $request, Conversation $conversation)
    {
        $user = auth()->user();
        if (! $conversation->users()->where('user_id', $user->id)->exists()) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:voice,video',
            'offer' => 'required|array',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $receiverId = $validated['receiver_id'];
        if ($receiverId === $user->id) {
            return response()->json(['success' => false, 'error' => 'Cannot call yourself'], 400);
        }

        if (! $conversation->users()->where('user_id', $receiverId)->exists()) {
            return response()->json(['success' => false, 'error' => 'User not in conversation'], 400);
        }

        $call = Call::create([
            'conversation_id' => $conversation->id,
            'caller_id' => $user->id,
            'receiver_id' => $receiverId,
            'type' => $validated['type'],
            'status' => 'ringing',
        ]);

        broadcast(new CallInitiated($call, $validated['offer'], $validated['type']))->toOthers();

        return response()->json([
            'success' => true,
            'call_id' => $call->id,
        ]);
    }

    public function answerCall(Request $request, Call $call)
    {
        $user = auth()->user();
        if ($call->receiver_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'answer' => 'required|array',
        ]);

        $call->update([
            'status' => 'answered',
            'started_at' => now(),
        ]);

        broadcast(new CallAnswered($call, $validated['answer']))->toOthers();

        return response()->json(['success' => true]);
    }

    public function declineCall(Request $request, Call $call)
    {
        $user = auth()->user();
        if ($call->receiver_id !== $user->id) {
            abort(403);
        }

        $call->update([
            'status' => 'declined',
            'ended_at' => now(),
        ]);

        broadcast(new CallDeclined($call))->toOthers();

        // Create call log message
        Message::create([
            'conversation_id' => $call->conversation_id,
            'sender_id' => $user->id,
            'type' => 'call_log',
            'call_data' => [
                'type' => $call->type,
                'status' => 'declined',
                'duration' => 0,
            ],
        ]);

        return response()->json(['success' => true]);
    }

    public function endCall(Request $request, Call $call)
    {
        $user = auth()->user();
        if (! in_array($user->id, [$call->caller_id, $call->receiver_id])) {
            abort(403);
        }

        $endedAt = now();
        $duration = $call->started_at ? $call->started_at->diffInSeconds($endedAt) : 0;

        $call->update([
            'status' => 'ended',
            'ended_at' => $endedAt,
            'duration' => $duration,
        ]);

        broadcast(new CallEnded($call))->toOthers();

        // Create call log message
        $status = $call->status === 'answered' ? 'ended' : 'missed';
        Message::create([
            'conversation_id' => $call->conversation_id,
            'sender_id' => $user->id,
            'type' => 'call_log',
            'call_data' => [
                'type' => $call->type,
                'status' => $status,
                'duration' => $duration,
            ],
        ]);

        return response()->json(['success' => true]);
    }

    public function iceCandidate(Request $request, Call $call)
    {
        $user = auth()->user();
        if (! in_array($user->id, [$call->caller_id, $call->receiver_id])) {
            abort(403);
        }

        $validated = $request->validate([
            'candidate' => 'required|array',
        ]);

        broadcast(new CallICECandidate($call, $validated['candidate'], $user->id))->toOthers();

        return response()->json(['success' => true]);
    }

    public function negotiate(Request $request, Call $call)
    {
        $user = auth()->user();
        if (! in_array($user->id, [$call->caller_id, $call->receiver_id])) {
            abort(403);
        }

        $validated = $request->validate([
            'offer' => 'required|array',
        ]);

        broadcast(new CallNegotiation($call, $validated['offer'], $user->id))->toOthers();

        return response()->json(['success' => true]);
    }

    public function start(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        $recipientId = $validated['recipient_id'];

        if ($userId === (int) $recipientId) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Cannot start a conversation with yourself.'], 400);
            }

            return back()->with('error', 'Cannot start a conversation with yourself.');
        }

        // Find existing direct conversation between user and recipient
        $conversation = Conversation::whereHas('users', fn ($q) => $q->where('user_id', $userId))
            ->whereHas('users', fn ($q) => $q->where('user_id', $recipientId))
            ->first();

        if (! $conversation) {
            $conversation = Conversation::create();
            ConversationMember::create(['conversation_id' => $conversation->id, 'user_id' => $userId, 'joined_at' => now()]);
            ConversationMember::create(['conversation_id' => $conversation->id, 'user_id' => $recipientId, 'joined_at' => now()]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'conversation_id' => $conversation->id,
                'redirect' => route('chat.show', $conversation->id),
            ]);
        }

        return redirect()->route('chat.show', $conversation->id);
    }
}
