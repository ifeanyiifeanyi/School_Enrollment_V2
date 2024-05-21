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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('passport_photo')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('phone')->nullable();
            $table->string('jamb_reg_no')->nullable();
            $table->string('religion')->nullable();
            $table->date('dob')->nullable();

            $table->string('secondary_school_attended')->nullable();
            $table->date('secondary_school_graduation_year')->nullable();
            $table->string('secondary_school_certificate_type')->nullable();

            $table->string('nin')->nullable();
            $table->string('nationality')->nullable();
            $table->text('permanent_residence_address')->nullable();
            $table->text('current_residence_address')->nullable();
            $table->text('lga_origin')->nullable();
            $table->text('state_of_origin')->nullable();
            $table->text('country_of_origin')->nullable();


            $table->string('guardian_name')->nullable();            
            $table->text('guardian_address')->nullable();
            $table->text('guardian_phone_number')->nullable();

            $table->string('exam_score')->nullable();

            $table->string('document_birth_certificate')->nullable();
            $table->string('document_local_government_identification')->nullable();
            $table->string('document_medical_report')->nullable();
            $table->string('document_secondary_school_certificate_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
