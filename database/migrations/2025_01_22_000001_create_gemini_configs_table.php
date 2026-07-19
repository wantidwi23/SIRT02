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
        Schema::create('gemini_configs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama config (e.g., "Production", "Development")
            $table->text('api_key'); // API Key
            $table->string('model')->default('gemini-pro'); // Model Gemini
            $table->float('temperature')->default(0.7); // Temperature setting
            $table->integer('max_output_tokens')->default(1024); // Max output tokens
            $table->text('system_prompt'); // System prompt untuk chatbot
            $table->boolean('is_active')->default(false); // Flag untuk config yang aktif
            $table->text('description')->nullable(); // Deskripsi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gemini_configs');
    }
};
