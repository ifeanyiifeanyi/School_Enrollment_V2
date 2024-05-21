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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->default(null)->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->default(null)->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->default(null)->constrained()->onDelete('cascade');
            $table->enum('admission_status', ['pending', 'approved', 'denied'])->nullable()->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
