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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('action'); // e.g., 'login', 'create', 'update', 'delete'
            $table->string('model_type')->nullable(); // e.g., 'Student', 'Graduate', 'Placement'
            $table->unsignedBigInteger('model_id')->nullable(); // ID of the affected record
            $table->json('details')->nullable(); // Additional details about the action
            $table->string('ip_address')->nullable();
            $table->timestamps();

            // Index for faster queries
            $table->index(['model_type', 'model_id']);
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
