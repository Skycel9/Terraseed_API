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
        Schema::create('taged', function (Blueprint $table) {
            $table->id('relation_id');
            $table->foreignId('tag_id');
            $table->foreignId('post_id');
            $table->timestamps();

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete(null);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taged');
    }
};
