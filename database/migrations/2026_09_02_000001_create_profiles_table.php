<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('username')->nullable()->unique();
            $table->string('full_name')->nullable();
            $table->string('avatar_url')->nullable();
            $table->text('bio')->nullable();
            $table->string('institution')->nullable();
            $table->json('skills')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('language', 5)->default('en');
            $table->json('privacy')->nullable();
            $table->json('notifications')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
