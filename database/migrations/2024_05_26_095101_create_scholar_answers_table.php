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
        Schema::create('scholar_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('scholar_applications')->onDelete('cascade');
            $table->foreignId('scholar_question_id')->constrained('scholar_questions')->onDelete('cascade');
            $table->foreignId('scholarship_id')->constrained('scholarships')->onDelete('cascade');
            $table->text('answer_text');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholar_answers');
    }
};
