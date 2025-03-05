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
                $table->string('sl_no')->after('id')->nullable();
            }
            if (!Schema::hasColumn('placed_students', 'batch_no')) {
                $table->string('batch_no')->after('sl_no')->nullable();
            }
            if (!Schema::hasColumn('placed_students', 'name')) {
                $table->string('name')->after('batch_no');
            }
            if (!Schema::hasColumn('placed_students', 'phone_number')) {
                $table->string('phone_number', 10)->after('name')->nullable();
            }
            if (!Schema::hasColumn('placed_students', 'company_name')) {
                $table->string('company_name')->after('phone_number');
            }
            if (!Schema::hasColumn('placed_students', 'designation')) {
                $table->string('designation')->after('company_name');
            }
            if (!Schema::hasColumn('placed_students', 'salary')) {
                $table->decimal('salary', 10, 2)->after('designation');
            }
            if (!Schema::hasColumn('placed_students', 'joining_date')) {
                $table->date('joining_date')->after('salary');
            }
            if (!Schema::hasColumn('placed_students', 'supporting_documents')) {
                $table->string('supporting_documents')->after('joining_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placed_students', function (Blueprint $table) {
            $table->dropColumn([
                'sl_no',
                'batch_no',
                'name',
                'phone_number',
                'company_name',
                'designation',
                'salary',
                'joining_date',
                'supporting_documents'
            ]);
        });
    }
};
