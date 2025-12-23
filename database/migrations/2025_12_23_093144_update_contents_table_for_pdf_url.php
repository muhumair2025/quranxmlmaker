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
        Schema::table('contents', function (Blueprint $table) {
            // Drop old PDF upload fields
            $table->dropColumn(['pdf_path', 'pdf_original_name', 'pdf_size']);
            
            // Add PDF URL field
            $table->string('pdf_url')->nullable()->after('answer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            // Drop URL field
            $table->dropColumn('pdf_url');
            
            // Restore old fields
            $table->string('pdf_path')->nullable();
            $table->string('pdf_original_name')->nullable();
            $table->integer('pdf_size')->nullable();
        });
    }
};
