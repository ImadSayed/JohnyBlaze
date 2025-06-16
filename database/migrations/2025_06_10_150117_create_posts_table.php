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
        Schema::create('posts', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('user_id')->constrained();
            $table->string('caption')->nullable();
            $table->string('image')->nullable();
            $table->string('image_type')->nullable(); // Optional: to store type of image (e.g., jpeg, png)
            $table->string('media')->nullable();
            $table->string('media_type')->nullable(); // Optional: to store type of media (e.g., video, audio)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
