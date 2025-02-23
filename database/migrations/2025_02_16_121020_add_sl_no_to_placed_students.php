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
            if (!Schema::hasColumn('placed_students', 'sl_no')) {
                $table->string('sl_no')->nullable()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placed_students', function (Blueprint $table) {
            $table->dropColumn('sl_no');
        });
    }
};
