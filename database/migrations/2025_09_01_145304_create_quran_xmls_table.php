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
        Schema::create('quran_xmls', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // lughat, tafseer, faidi
            $table->string('media_type'); // audio, video
            $table->integer('surah');
            $table->integer('ayah');
            $table->text('link');
            $table->string('filename');
            $table->longText('xml_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quran_xmls');
    }
};
