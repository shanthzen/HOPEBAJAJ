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
        // Skip this migration since we already have the joining_date column
        if (!Schema::hasColumn('placed_students', 'joining_date')) {
            Schema::table('placed_students', function (Blueprint $table) {
                $table->date('joining_date')->nullable()->after('salary');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placed_students', function (Blueprint $table) {
            $table->dropColumn('joining_date');
        });
    }
};
