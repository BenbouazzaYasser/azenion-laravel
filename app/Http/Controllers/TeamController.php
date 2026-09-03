<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamCategory;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = Team::with(['owner.profile', 'category', 'members.user.profile']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->input('category')));
        }

        $teams = $query->latest()->paginate(12);
        $categories = TeamCategory::all();

        return view('sections.teams', compact('teams', 'categories'));
    }

    public function show($id)
    {
        $team = Team::with(['owner.profile', 'category', 'members.user.profile', 'openRoles', 'projects'])->findOrFail($id);

        return view('sections.team-detail', compact('team'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:team_categories,id',
            'visibility' => 'nullable|string|in:public,private',
        ]);

        $team = Team::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::random(5),
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
            'visibility' => $validated['visibility'] ?? 'public',
            'owner_id' => auth()->id(),
        ]);

        TeamMember::create([
            'team_id' => $team->id,
            'user_id' => auth()->id(),
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()->route('teams')->with('success', 'Team created successfully!');
    }

    public function join(Request $request, Team $team)
    {
        if ($team->members()->where('user_id', auth()->id())->exists()) {
            return back()->with('info', 'You are already a member of this team.');
        }

        TeamMember::create([
            'team_id' => $team->id,
            'user_id' => auth()->id(),
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return back()->with('success', 'Successfully joined team!');
    }

    public function leave(Request $request, Team $team)
    {
        if ($team->owner_id === auth()->id()) {
            return back()->with('error', 'Team owners cannot leave their own team.');
        }

        $team->members()->where('user_id', auth()->id())->delete();

        return back()->with('success', 'Successfully left team.');
    }
}
