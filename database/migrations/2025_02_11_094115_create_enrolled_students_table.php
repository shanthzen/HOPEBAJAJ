<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('enrolled_students')) {
            Schema::create('enrolled_students', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('full_name');
                $table->string('email')->unique();
                $table->string('contact_number');
                $table->string('whatsapp_number')->nullable();
                $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('set null');
                $table->string('batch_no');
                $table->time('batch_timings')->nullable();
                $table->string('faculty_name')->nullable();
                $table->date('enrollment_date');
                $table->string('course_enrolled');
                $table->string('status')->default('active');
                $table->string('id_proof_type')->nullable();
                $table->string('id_proof_number')->nullable()->unique();
                $table->date('date_of_birth')->nullable();
                $table->string('gender')->nullable();
                $table->string('qualification')->nullable();
                $table->string('college_name')->nullable();
                $table->text('college_address')->nullable();
                $table->boolean('looking_for_job')->default(false);
                $table->string('photo')->nullable();
                $table->string('student_signature')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('enrolled_students');
    }
};
