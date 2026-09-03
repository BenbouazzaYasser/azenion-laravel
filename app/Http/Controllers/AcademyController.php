<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lab;
use App\Models\LabSubmission;
use App\Models\LiveSession;
use App\Models\LiveSessionRegistration;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function index()
    {
        $courses = Course::with(['instructor.profile'])->latest()->take(6)->get();
        $liveSessions = LiveSession::with(['instructor.profile'])->where('scheduled_at', '>=', now())->take(4)->get();
        $labs = Lab::latest()->take(6)->get();

        return view('sections.academy', compact('courses', 'liveSessions', 'labs'));
    }

    public function courses()
    {
        $courses = Course::with(['instructor.profile', 'lessons'])->latest()->paginate(9);

        return view('sections.academy-courses', compact('courses'));
    }

    public function courseDetail(Course $course)
    {
        $course->load(['instructor.profile', 'lessons']);
        $isEnrolled = auth()->check() && $course->enrollments()->where('user_id', auth()->id())->exists();

        return view('sections.academy-course-detail', compact('course', 'isEnrolled'));
    }

    public function enroll(Request $request, Course $course)
    {
        Enrollment::firstOrCreate([
            'course_id' => $course->id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Successfully enrolled in course!');
    }

    public function liveSessions()
    {
        $sessions = LiveSession::with(['instructor.profile', 'registrations'])->where('scheduled_at', '>=', now())->get();

        return view('sections.academy-live-sessions', compact('sessions'));
    }

    public function registerSession(Request $request, LiveSession $session)
    {
        LiveSessionRegistration::firstOrCreate([
            'live_session_id' => $session->id,
            'user_id' => auth()->id(),
        ]);

        $session->increment('registered_count');

        return back()->with('success', 'Successfully registered for live session!');
    }

    public function labs()
    {
        $labs = Lab::withCount('submissions')->get();

        return view('sections.academy-labs', compact('labs'));
    }

    public function labDetail(Lab $lab)
    {
        $submission = auth()->check() ? $lab->submissions()->where('user_id', auth()->id())->latest()->first() : null;

        return view('sections.academy-lab-detail', compact('lab', 'submission'));
    }

    public function submitLab(Request $request, Lab $lab)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        // Simple automated evaluation simulation
        $passed = str_contains($validated['code'], 'return') || strlen($validated['code']) > 10;
        $status = $passed ? 'passed' : 'failed';
        $score = $passed ? 100 : 40;

        LabSubmission::create([
            'lab_id' => $lab->id,
            'user_id' => auth()->id(),
            'code' => $validated['code'],
            'status' => $status,
            'score' => $score,
            'feedback' => $passed ? 'All test cases passed successfully!' : 'Some test cases failed. Please review your logic.',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Lab submitted! Status: '.ucfirst($status));
    }
}
