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
        Schema::create('postmeta', function (Blueprint $table) {
            $table->id('meta_id');
            $table->foreignId('post_id');
            $table->enum('meta_key', ["_meta_attachment_file", "_meta_attachment_metadata"]);
            $table->string("meta_value");
            $table->softDeletes();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postmeta');
    }
};
