<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update to gemini-2.0-flash (latest model with full API v1beta support)
        DB::table('gemini_configs')
            ->whereIn('model', ['gemini-pro', 'gemini-1.5-pro', 'gemini-1.5-pro-latest'])
            ->update(['model' => 'gemini-2.0-flash']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to gemini-pro if needed
        DB::table('gemini_configs')
            ->where('model', 'gemini-2.0-flash')
            ->update(['model' => 'gemini-pro']);
    }
};
