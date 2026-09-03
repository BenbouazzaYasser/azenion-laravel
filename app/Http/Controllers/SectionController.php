<?php

namespace App\Http\Controllers;

class SectionController extends Controller
{
    public function teams()
    {
        return view('sections.teams');
    }

    public function projects()
    {
        return view('sections.projects');
    }

    public function branches()
    {
        return view('sections.branches');
    }

    public function servers()
    {
        return view('sections.servers');
    }

    public function community()
    {
        return view('sections.community');
    }

    public function feed()
    {
        return view('sections.feed');
    }

    public function showcase()
    {
        return view('sections.showcase');
    }

    public function announcements()
    {
        return view('sections.announcements');
    }

    public function chat()
    {
        return view('sections.chat');
    }

    public function academy()
    {
        return view('sections.academy');
    }

    public function academyCourses()
    {
        return view('sections.academy-courses');
    }

    public function academyLiveSessions()
    {
        return view('sections.academy-live-sessions');
    }

    public function academyLabs()
    {
        return view('sections.academy-labs');
    }
}
