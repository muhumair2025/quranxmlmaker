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
        Schema::table('categories', function (Blueprint $table) {
            // Drop old single name and icon fields
            $table->dropColumn(['name', 'icon']);
            
            // Add multilingual name fields
            $table->string('name_english')->after('id');
            $table->string('name_urdu')->after('name_english');
            $table->string('name_arabic')->after('name_urdu');
            $table->string('name_pashto')->after('name_arabic');
            
            // Add foreign key to icon library
            $table->foreignId('icon_library_id')->nullable()->after('description')->constrained('icon_library')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Drop new fields
            $table->dropForeign(['icon_library_id']);
            $table->dropColumn(['name_english', 'name_urdu', 'name_arabic', 'name_pashto', 'icon_library_id']);
            
            // Restore old fields
            $table->string('name')->after('id');
            $table->string('icon')->nullable()->after('description');
        });
    }
};
