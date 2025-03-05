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
        Schema::table('enrolled_students', function (Blueprint $table) {
            if (!Schema::hasColumn('enrolled_students', 'batch_no')) {
                $table->string('batch_no')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'batch_timings')) {
                $table->time('batch_timings')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'faculty_name')) {
                $table->string('faculty_name')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'id_proof_type')) {
                $table->string('id_proof_type')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'id_proof_number')) {
                $table->string('id_proof_number')->unique()->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'contact_number')) {
                $table->string('contact_number')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'qualification')) {
                $table->string('qualification')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'college_name')) {
                $table->string('college_name')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'college_address')) {
                $table->text('college_address')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'is_pursuing')) {
                $table->boolean('is_pursuing')->default(false);
            }
            if (!Schema::hasColumn('enrolled_students', 'looking_for_job')) {
                $table->boolean('looking_for_job')->default(false);
            }
            if (!Schema::hasColumn('enrolled_students', 'student_photo')) {
                $table->string('student_photo')->nullable();
            }
            if (!Schema::hasColumn('enrolled_students', 'student_signature')) {
                $table->string('student_signature')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrolled_students', function (Blueprint $table) {
            $columns = [
                'batch_no',
                'batch_timings',
                'faculty_name',
                'id_proof_type',
                'id_proof_number',
                'date_of_birth',
                'contact_number',
                'whatsapp_number',
                'gender',
                'qualification',
                'college_name',
                'college_address',
                'is_pursuing',
                'looking_for_job',
                'student_photo',
                'student_signature'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('enrolled_students', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
