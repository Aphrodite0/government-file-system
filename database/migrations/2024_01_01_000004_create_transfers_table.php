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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('from_office_id')->constrained('offices')->onDelete('cascade');
            $table->foreignId('to_office_id')->constrained('offices')->onDelete('cascade');
            $table->enum('status', ['pending', 'sent', 'received', 'read', 'rejected'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('sent_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('priority')->default('normal'); // low, normal, high, urgent
            $table->timestamps();
            
            $table->index('document_id');
            $table->index('from_office_id');
            $table->index('to_office_id');
            $table->index('status');
            $table->index('sent_at');
            $table->index('received_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
