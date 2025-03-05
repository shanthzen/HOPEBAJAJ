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
            if (!Schema::hasColumn('placed_students', 'graduate_id')) {
                $table->foreignId('graduate_id')->nullable()->constrained('graduates')->onDelete('set null');
            } else {
                $table->foreignId('graduate_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placed_students', function (Blueprint $table) {
            $table->foreignId('graduate_id')->nullable(false)->change();
        });
    }
};
