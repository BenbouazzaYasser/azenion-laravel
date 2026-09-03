<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\UpdateLike;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $posts = Post::with(['author.profile', 'likes', 'saves'])->latest()->paginate(15);

        return view('sections.feed', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'title' => 'nullable|string|max:255',
            'image_url' => 'nullable|string',
        ]);

        Post::create([
            'author_id' => auth()->id(),
            'body' => $validated['body'],
            'title' => $validated['title'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
            'source_type' => 'post',
        ]);

        return redirect()->route('feed')->with('success', 'Post published successfully!');
    }

    public function like(Request $request, Post $post)
    {
        $userId = auth()->id();
        $like = UpdateLike::where('user_id', $userId)
            ->where('target_type', 'post')
            ->where('target_id', $post->id)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            UpdateLike::create([
                'user_id' => $userId,
                'target_type' => 'post',
                'target_id' => $post->id,
            ]);
            $liked = true;
        }

        $likesCount = $post->likes()->count();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $likesCount,
            ]);
        }

        return back()->with('success', $liked ? 'Post liked.' : 'Post unliked.');
    }

    public function save(Request $request, Post $post)
    {
        $userId = auth()->id();
        $save = UpdateLike::where('user_id', $userId)
            ->where('target_type', 'post_save')
            ->where('target_id', $post->id)
            ->first();

        if ($save) {
            $save->delete();
            $saved = false;
        } else {
            UpdateLike::create([
                'user_id' => $userId,
                'target_type' => 'post_save',
                'target_id' => $post->id,
            ]);
            $saved = true;
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'saved' => $saved,
            ]);
        }

        return back()->with('success', $saved ? 'Post saved.' : 'Post unsaved.');
    }
}
