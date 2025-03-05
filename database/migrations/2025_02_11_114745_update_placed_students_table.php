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
            // Drop existing columns
            $table->dropForeign(['graduate_id']);
            $table->dropColumn([
                'graduate_id',
                'email',
                'contact_number',
                'joining_date',
                'offer_letter',
                'documents',
                'status'
            ]);

            // Add new columns
            $table->string('sl_no')->after('id');
            $table->string('batch_no')->after('sl_no');
            $table->string('phone_number')->after('name');
            $table->string('supporting_documents')->nullable()->after('salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placed_students', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn([
                'sl_no',
                'batch_no',
                'phone_number',
                'supporting_documents'
            ]);

            // Restore old columns
            $table->foreignId('graduate_id')->constrained('graduates')->onDelete('cascade');
            $table->string('email');
            $table->string('contact_number');
            $table->date('joining_date');
            $table->string('offer_letter')->nullable();
            $table->json('documents')->nullable();
            $table->string('status')->default('active');
        });
    }
};
