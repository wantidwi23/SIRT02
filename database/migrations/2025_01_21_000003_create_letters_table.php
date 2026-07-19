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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id');
            $table->enum('type', ['surat_keterangan', 'surat_pengalaman', 'surat_tidak_mampu', 'surat_domisili', 'surat_lainnya'])->default('surat_lainnya');
            $table->text('purpose');
            $table->text('notes')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'siap_diambil', 'diambil', 'ditolak'])->default('menunggu');
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('taken_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('letter_file')->nullable();
            $table->timestamps();

            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
