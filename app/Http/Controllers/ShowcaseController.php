<?php

namespace App\Http\Controllers;

use App\Models\ShowcaseItem;
use Illuminate\Http\Request;

class ShowcaseController extends Controller
{
    public function index()
    {
        $showcases = ShowcaseItem::with(['user.profile'])->latest()->paginate(12);

        return view('sections.showcase', compact('showcases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'live_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'tags' => 'nullable|string', // comma separated
        ]);

        $tags = $validated['tags'] ? array_map('trim', explode(',', $validated['tags'])) : [];

        ShowcaseItem::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_url' => $validated['image_url'] ?? null,
            'live_url' => $validated['live_url'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'tags' => $tags,
        ]);

        return redirect()->route('showcase')->with('success', 'Showcase item submitted successfully!');
    }

    public function like(ShowcaseItem $showcase)
    {
        $showcase->increment('likes_count');

        return back()->with('success', 'Liked showcase item!');
    }
}
