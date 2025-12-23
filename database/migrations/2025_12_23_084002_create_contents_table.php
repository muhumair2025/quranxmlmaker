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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['text', 'qa', 'pdf']); // Content types
            $table->string('title');
            
            // For text content
            $table->longText('text_content')->nullable();
            
            // For Q&A content
            $table->text('question')->nullable();
            $table->longText('answer')->nullable();
            
            // For PDF content
            $table->string('pdf_path')->nullable();
            $table->string('pdf_original_name')->nullable();
            $table->integer('pdf_size')->nullable(); // in bytes
            
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
