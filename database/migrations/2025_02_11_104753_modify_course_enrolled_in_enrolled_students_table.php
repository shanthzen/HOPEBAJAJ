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
            if (Schema::hasColumn('enrolled_students', 'course_enrolled')) {
                $table->string('course_enrolled')->nullable(false)->change();
            } else {
                $table->string('course_enrolled')->nullable(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrolled_students', function (Blueprint $table) {
            if (Schema::hasColumn('enrolled_students', 'course_enrolled')) {
                $table->string('course_enrolled')->nullable(false)->change();
            }
        });
    }
};
