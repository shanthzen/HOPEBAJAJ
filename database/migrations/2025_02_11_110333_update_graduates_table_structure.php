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
        Schema::table('graduates', function (Blueprint $table) {
            // Drop existing columns that we don't need
            $table->dropForeign(['student_id']);
            $table->dropColumn([
                'student_id',
                'email',
                'contact_number',
                'course_completed',
                'graduation_date',
                'grade',
                'certificate',
                'status'
            ]);

            // Add new columns
            $table->string('phone_number');
            $table->string('id_proof_type');
            $table->string('id_proof_number')->unique();
            $table->string('course_name');
            $table->string('course_duration');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days_attended');
            $table->string('certificate_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graduates', function (Blueprint $table) {
            // Restore original columns
            $table->foreignId('student_id')->constrained('enrolled_students')->onDelete('cascade');
            $table->string('email');
            $table->string('contact_number');
            $table->string('course_completed');
            $table->date('graduation_date');
            $table->string('grade')->nullable();
            $table->string('certificate')->nullable();
            $table->string('status')->default('active');

            // Drop new columns
            $table->dropColumn([
                'phone_number',
                'id_proof_type',
                'id_proof_number',
                'course_name',
                'course_duration',
                'start_date',
                'end_date',
                'total_days_attended',
                'certificate_path'
            ]);
        });
    }
};
