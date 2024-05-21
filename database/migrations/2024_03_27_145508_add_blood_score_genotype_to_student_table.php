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
        Schema::table('students', function (Blueprint $table) {
            $table->string('jamb_score')->nullable()->after('jamb_reg_no');
            $table->string('blood_group')->nullable()->after('dob');
            $table->string('genotype')->nullable()->after('blood_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('jamb_score');
            $table->dropColumn('blood_group');
            $table->dropColumn('genotype');
        });
    }
};
