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
        Schema::create('topicmeta', function (Blueprint $table) {
            $table->id('meta_id');
            $table->enum('meta_key', ["_meta_topic_metadata"]);
            $table->string('meta_value');
            $table->foreignId('topic_id');
            $table->foreignId('post_id');
            $table->softDeletes();

            $table->foreign("topic_id")->references('id')->on('topics')->onDelete(null);
            $table->foreign("post_id")->references('id')->on('posts')->onDelete(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topicmeta');
    }
};
