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
        Schema::create('scholar_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_id')->constrained('scholarships')->onDelete('cascade');
            $table->string('question_text');
            $table->string('type')->default('text'); // text, multiple-choice, checkbox
            $table->json('options')->nullable(); // For storing options for multiple-choice and checkbox
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholar_questions');
    }
};
