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
        if (!Schema::hasTable('graduates')) {
            Schema::create('graduates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('enrolled_students')->onDelete('cascade');
                $table->string('name');
                $table->string('email');
                $table->string('contact_number');
                $table->string('course_completed');
                $table->string('batch_no');
                $table->date('graduation_date');
                $table->string('grade')->nullable();
                $table->string('certificate_no')->unique()->nullable();
                $table->string('certificate')->nullable();
                $table->string('status')->default('active');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduates');
    }
};
