<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('profile');

        return view('profile', ['user' => $user]);
    }
}
