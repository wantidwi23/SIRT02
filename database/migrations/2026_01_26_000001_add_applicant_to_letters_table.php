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
        Schema::table('letters', function (Blueprint $table) {
            $table->string('applicant_name')->nullable()->after('resident_id');
            $table->string('applicant_nik')->nullable()->after('applicant_name');
            $table->string('identity_image')->nullable()->after('applicant_nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropColumn(['applicant_name', 'applicant_nik', 'identity_image']);
        });
    }
};
