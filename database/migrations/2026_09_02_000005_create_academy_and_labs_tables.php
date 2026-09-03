<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academy_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category')->default('general');
            $table->string('level')->default('beginner');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('duration')->nullable();
            $table->integer('lessons_count')->default(0);
            $table->string('thumbnail_url')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('academy_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('academy_courses')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->string('video_url')->nullable();
            $table->string('duration')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('academy_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('academy_courses')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('progress')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->unique(['course_id', 'user_id']);
        });

        Schema::create('live_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('instructor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('scheduled_at');
            $table->string('duration')->nullable();
            $table->string('meeting_url')->nullable();
            $table->integer('capacity')->default(100);
            $table->integer('registered_count')->default(0);
            $table->timestamps();
        });

        Schema::create('live_session_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_session_id')->constrained('live_sessions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();
            $table->unique(['live_session_id', 'user_id']);
        });

        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('difficulty')->default('beginner');
            $table->string('category')->default('general');
            $table->text('starter_code')->nullable();
            $table->text('solution_code')->nullable();
            $table->json('test_cases')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('lab_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_id')->constrained('labs')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('code');
            $table->string('status')->default('pending'); // pending, passed, failed
            $table->integer('score')->default(0);
            $table->text('feedback')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_submissions');
        Schema::dropIfExists('labs');
        Schema::dropIfExists('live_session_registrations');
        Schema::dropIfExists('live_sessions');
        Schema::dropIfExists('academy_enrollments');
        Schema::dropIfExists('academy_lessons');
        Schema::dropIfExists('academy_courses');
    }
};
