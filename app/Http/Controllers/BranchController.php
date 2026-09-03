<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchMember;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount('members')->get();

        return view('sections.branches', compact('branches'));
    }

    public function show($id)
    {
        $branch = Branch::with(['members.user.profile'])->findOrFail($id);

        return view('sections.branch-detail', compact('branch'));
    }

    public function join(Request $request, Branch $branch)
    {
        if ($branch->members()->where('user_id', auth()->id())->exists()) {
            return back()->with('info', 'You are already a member of this branch.');
        }

        BranchMember::create([
            'branch_id' => $branch->id,
            'user_id' => auth()->id(),
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return back()->with('success', 'Successfully joined branch!');
    }

    public function leave(Request $request, Branch $branch)
    {
        $branch->members()->where('user_id', auth()->id())->delete();

        return back()->with('success', 'Successfully left branch.');
    }
}
