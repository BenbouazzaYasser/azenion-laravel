<?php

use App\Http\Controllers\AcademyController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

// Teams
Route::get('/teams', [TeamController::class, 'index'])->name('teams');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

// Projects
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

// Branches
Route::get('/branches', [BranchController::class, 'index'])->name('branches');
Route::get('/branches/{branch}', [BranchController::class, 'show'])->name('branches.show');

// Servers
Route::get('/servers', [ServerController::class, 'index'])->name('servers');
Route::get('/servers/{server}', [ServerController::class, 'show'])->name('servers.show');

Route::get('/community', [PageController::class, 'home'])->name('community');

// Feed
Route::get('/feed', [FeedController::class, 'index'])->name('feed');

// Showcase
Route::get('/showcase', [ShowcaseController::class, 'index'])->name('showcase');

// Announcements
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');

// Academy
Route::get('/academy', [AcademyController::class, 'index'])->name('academy');
Route::get('/academy/courses', [AcademyController::class, 'courses'])->name('academy.courses');
Route::get('/academy/courses/{course}', [AcademyController::class, 'courseDetail'])->name('academy.courses.show');
Route::get('/academy/live-sessions', [AcademyController::class, 'liveSessions'])->name('academy.live-sessions');
Route::get('/academy/labs', [AcademyController::class, 'labs'])->name('academy.labs');
Route::get('/academy/labs/{lab}', [AcademyController::class, 'labDetail'])->name('academy.labs.show');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/join', [PageController::class, 'join'])->name('join');
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated actions & views
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Teams actions
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::post('/teams/{team}/join', [TeamController::class, 'join'])->name('teams.join');
    Route::post('/teams/{team}/leave', [TeamController::class, 'leave'])->name('teams.leave');

    // Projects actions
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::post('/projects/{project}/join', [ProjectController::class, 'join'])->name('projects.join');
    Route::post('/projects/{project}/leave', [ProjectController::class, 'leave'])->name('projects.leave');

    // Branches actions
    Route::post('/branches/{branch}/join', [BranchController::class, 'join'])->name('branches.join');
    Route::post('/branches/{branch}/leave', [BranchController::class, 'leave'])->name('branches.leave');

    // Servers actions
    Route::post('/servers', [ServerController::class, 'store'])->name('servers.store');
    Route::post('/servers/{server}/join', [ServerController::class, 'join'])->name('servers.join');
    Route::post('/servers/{server}/leave', [ServerController::class, 'leave'])->name('servers.leave');
    Route::post('/servers/{server}/channels/{channel}/messages', [ServerController::class, 'storeMessage'])->name('servers.channels.messages.store');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}/messages', [ChatController::class, 'store'])->name('chat.messages.store');
    Route::post('/chat/{conversation}/voice', [ChatController::class, 'storeVoice'])->name('chat.messages.voice');
    Route::post('/chat/start', [ChatController::class, 'start'])->name('chat.start');

    // Call routes
    Route::post('/chat/{conversation}/call', [ChatController::class, 'initiateCall'])->name('chat.call.initiate');
    Route::post('/chat/call/{call}/answer', [ChatController::class, 'answerCall'])->name('chat.call.answer');
    Route::post('/chat/call/{call}/decline', [ChatController::class, 'declineCall'])->name('chat.call.decline');
    Route::post('/chat/call/{call}/end', [ChatController::class, 'endCall'])->name('chat.call.end');
    Route::post('/chat/call/{call}/ice', [ChatController::class, 'iceCandidate'])->name('chat.call.ice');
    Route::post('/chat/call/{call}/negotiate', [ChatController::class, 'negotiate'])->name('chat.call.negotiate');

    // Feed actions
    Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');
    Route::post('/feed/{post}/like', [FeedController::class, 'like'])->name('feed.like');
    Route::post('/feed/{post}/save', [FeedController::class, 'save'])->name('feed.save');

    // Showcase actions
    Route::post('/showcase', [ShowcaseController::class, 'store'])->name('showcase.store');
    Route::post('/showcase/{showcase}/like', [ShowcaseController::class, 'like'])->name('showcase.like');

    // Announcements actions
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');

    // Academy actions
    Route::post('/academy/courses/{course}/enroll', [AcademyController::class, 'enroll'])->name('academy.courses.enroll');
    Route::post('/academy/live-sessions/{session}/register', [AcademyController::class, 'registerSession'])->name('academy.live-sessions.register');
    Route::post('/academy/labs/{lab}/submit', [AcademyController::class, 'submitLab'])->name('academy.labs.submit');
});
