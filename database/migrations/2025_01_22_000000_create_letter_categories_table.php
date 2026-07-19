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
        Schema::create('letter_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Modify letters table to add category_id
        Schema::table('letters', function (Blueprint $table) {
            $table->unsignedBigInteger('letter_category_id')->nullable()->after('type');
            $table->foreign('letter_category_id')->references('id')->on('letter_categories')->onDelete('set null');
            // Drop the type enum column after adding category
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropForeign(['letter_category_id']);
            $table->dropColumn('letter_category_id');
            $table->enum('type', ['surat_keterangan', 'surat_pengalaman', 'surat_tidak_mampu', 'surat_domisili', 'surat_lainnya'])->default('surat_lainnya')->after('resident_id');
        });

        Schema::dropIfExists('letter_categories');
    }
};
