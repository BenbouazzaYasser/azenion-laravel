<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('conversation_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('conversations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('last_read_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unique(['conversation_id', 'user_id']);
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('conversations')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->string('image_url')->nullable();
            $table->timestamp('edited_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('source_type')->default('post'); // post, project, team
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('group_name')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('title')->nullable();
            $table->text('body');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('showcase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->json('tags')->nullable();
            $table->integer('likes_count')->default(0);
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            $table->string('category')->default('general');
            $table->boolean('pinned')->default(false);
            $table->timestamps();
        });

        Schema::create('update_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('target_type');
            $table->unsignedBigInteger('target_id');
            $table->timestamps();
            $table->unique(['user_id', 'target_type', 'target_id']);
        });

        Schema::create('update_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('target_type');
            $table->unsignedBigInteger('target_id');
            $table->unsignedBigInteger('parent_comment_id')->nullable();
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type');
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('target_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('update_comments');
        Schema::dropIfExists('update_likes');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('showcase_items');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversation_members');
        Schema::dropIfExists('conversations');
    }
};
