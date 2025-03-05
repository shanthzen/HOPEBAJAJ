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
            if (Schema::hasColumn('enrolled_students', 'enrollment_date')) {
                $table->date('enrollment_date')->nullable()->change();
            } else {
                $table->date('enrollment_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrolled_students', function (Blueprint $table) {
            if (Schema::hasColumn('enrolled_students', 'enrollment_date')) {
                $table->date('enrollment_date')->nullable(false)->change();
            }
        });
    }
};
