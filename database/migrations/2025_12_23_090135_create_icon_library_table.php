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
        Schema::create('icon_library', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Icon name/title
            $table->string('file_path'); // Path to the icon file
            $table->string('file_type'); // png, svg, jpg, etc.
            $table->integer('file_size'); // Size in bytes
            $table->string('original_name'); // Original filename
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('icon_library');
    }
};
