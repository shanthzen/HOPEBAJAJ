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
        Schema::table('placed_students', function (Blueprint $table) {
            // First drop the existing column if it exists
            if (Schema::hasColumn('placed_students', 'joining_date')) {
                $table->dropColumn('joining_date');
            }
            
            // Add the column again with correct type
            $table->date('joining_date')->nullable()->after('salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placed_students', function (Blueprint $table) {
            if (Schema::hasColumn('placed_students', 'joining_date')) {
                $table->dropColumn('joining_date');
            }
        });
    }
};
