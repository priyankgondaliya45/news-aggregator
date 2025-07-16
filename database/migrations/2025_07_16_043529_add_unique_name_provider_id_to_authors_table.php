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
        Schema::table('', function (Blueprint $table) {
            //
        });
        Schema::table('authors', function (Blueprint $table) {
            $table->dropUnique(['name']); 
            $table->unique(['name', 'provider_id'], 'unique_name_author');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropUnique('unique_name_author');
            $table->unique('name');
        });
    }
};
