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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('authors')->nullOnDelete()->index();
            $table->text('url');
            $table->text('url_to_image')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->foreign('source_id', 'fk_articles_source_id')->nullable()
                ->references('id')
                ->on('news_sources')
                ->nullOnDelete();
            $table->dateTime('published_at');
            $table->softDeletes(); // 👈 adds deleted_at column
            $table->timestamps();

            $table->index(['category', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
