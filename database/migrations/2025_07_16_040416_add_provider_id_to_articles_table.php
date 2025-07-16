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
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('provider_id')
                ->after('source_id')
                ->nullable()
                ->constrained('news_providers')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['provider_id']);

            // Then drop the column
            $table->dropColumn('provider_id');
        });
    }
};
