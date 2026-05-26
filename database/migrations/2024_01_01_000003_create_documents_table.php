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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('filename')->unique();
            $table->string('original_name');
            $table->string('file_path');
            $table->bigInteger('file_size');
            $table->string('file_type')->nullable(); // pdf, doc, docx, etc
            $table->text('description')->nullable();
            $table->string('document_category')->nullable();
            $table->string('reference_number')->nullable();
            $table->boolean('is_classified')->default(false); // for sensitive documents
            $table->timestamps();
            
            $table->index('office_id');
            $table->index('created_by');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
