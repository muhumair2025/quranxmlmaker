<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('live_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('youtube_url');
            $table->dateTime('scheduled_at')->nullable();
            $table->enum('status', ['upcoming', 'live', 'ended'])->default('upcoming');
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_videos');
    }
};
