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
            $table->id();
            $table->string('post_title')->nullable();
            $table->string('post_slug')->unique()->nullable();
            $table->string('post_description')->nullable();
            $table->longText('post_content')->nullable();
            $table->string('post_coordinates')->nullable();
            $table->enum('post_type', ["post", "attachment", "comment", "profile"]);
            $table->foreignId('post_author');
            $table->foreignId('post_parent')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("post_author")->references('id')->on('users')->onDelete(null);
            $table->foreign('post_parent')->references('id')->on('topics')->onDelete(null);
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
