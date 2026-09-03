<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['author.profile'])->orderBy('pinned', 'desc')->latest()->paginate(10);

        return view('sections.announcements', compact('announcements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'nullable|string',
            'pinned' => 'nullable|boolean',
        ]);

        Announcement::create([
            'author_id' => auth()->id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
            'category' => $validated['category'] ?? 'general',
            'pinned' => $validated['pinned'] ?? false,
        ]);

        return redirect()->route('announcements')->with('success', 'Announcement published.');
    }
}
