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
        if (!Schema::hasTable('placed_students')) {
            Schema::create('placed_students', function (Blueprint $table) {
                $table->id();
                $table->foreignId('graduate_id')->constrained('graduates')->onDelete('cascade');
                $table->string('name');
                $table->string('email');
                $table->string('contact_number');
                $table->string('company_name');
                $table->string('designation');
                $table->decimal('salary', 10, 2); // Store salary in paise (1 LPA = 100000)
                $table->date('joining_date');
                $table->string('offer_letter')->nullable();
                $table->json('documents')->nullable();
                $table->string('status')->default('active');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placed_students');
    }
};
