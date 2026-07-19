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
            $table->unsignedBigInteger('head_of_family_id')->nullable()->after('resident_id');
            $table->foreign('head_of_family_id')->references('id')->on('head_of_families')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropForeign(['head_of_family_id']);
            $table->dropColumn('head_of_family_id');
        });
    }
};
