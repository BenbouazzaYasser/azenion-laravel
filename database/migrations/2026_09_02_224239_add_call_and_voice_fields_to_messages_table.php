<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('type')->default('text'); // text, voice, call_log
            $table->string('audio_url')->nullable();
            $table->integer('duration')->nullable(); // seconds
            $table->json('call_data')->nullable(); // {type: 'voice'|'video', status: 'missed'|'answered'|'declined', duration}
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['type', 'audio_url', 'duration', 'call_data']);
        });
    }
};
