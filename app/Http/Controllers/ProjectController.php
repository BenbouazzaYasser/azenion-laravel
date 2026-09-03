<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['owner.profile', 'team', 'members.user.profile']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $projects = $query->latest()->paginate(12);

        return view('sections.projects', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::with(['owner.profile', 'team', 'members.user.profile'])->findOrFail($id);

        return view('sections.project-detail', compact('project'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_id' => 'nullable|exists:teams,id',
            'visibility' => 'nullable|string|in:public,private',
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::random(5),
            'description' => $validated['description'] ?? null,
            'team_id' => $validated['team_id'] ?? null,
            'visibility' => $validated['visibility'] ?? 'public',
            'owner_id' => auth()->id(),
        ]);

        ProjectMember::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()->route('projects')->with('success', 'Project created successfully!');
    }

    public function join(Request $request, Project $project)
    {
        if ($project->members()->where('user_id', auth()->id())->exists()) {
            return back()->with('info', 'You are already a member of this project.');
        }

        ProjectMember::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return back()->with('success', 'Successfully joined project!');
    }

    public function leave(Request $request, Project $project)
    {
        if ($project->owner_id === auth()->id()) {
            return back()->with('error', 'Project owners cannot leave their own project.');
        }

        $project->members()->where('user_id', auth()->id())->delete();

        return back()->with('success', 'Successfully left project.');
    }
}
