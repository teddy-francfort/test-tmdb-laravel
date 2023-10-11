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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tmdb_id');
            $table->string('imdb_id')->nullable();

            $table->string('title');
            $table->date('release_date')->nullable();
            $table->text('overview')->nullable();
            $table->string('poster_path')->nullable();

            $table->boolean('is_trending_day')->default(false);
            $table->boolean('is_trending_week')->default(false);

            $table->text('data')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
