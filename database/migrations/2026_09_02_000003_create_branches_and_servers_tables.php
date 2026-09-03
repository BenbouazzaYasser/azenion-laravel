<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('full_name')->nullable();
            $table->text('description')->nullable();
            $table->string('city')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('cover_url')->nullable();
            $table->timestamps();
        });

        Schema::create('branch_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role')->default('member');
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();
            $table->unique(['branch_id', 'user_id']);
        });

        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon_url')->nullable();
            $table->string('banner_url')->nullable();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('category')->default('general');
            $table->timestamps();
        });

        Schema::create('server_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained('servers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role')->default('member');
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();
            $table->unique(['server_id', 'user_id']);
        });

        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained('servers')->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('text'); // text, voice
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('channels');
        Schema::dropIfExists('server_members');
        Schema::dropIfExists('servers');
        Schema::dropIfExists('branch_members');
        Schema::dropIfExists('branches');
    }
};
