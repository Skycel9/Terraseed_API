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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_login');
            $table->string('user_display_name')->nullable();
            $table->string('user_email');
            $table->integer('user_phone_number')->nullable();
            $table->integer('user_phone_ext')->nullable();
            $table->string('user_lastname')->nullable();
            $table->string('user_firstname')->nullable();
            $table->date('user_birthday')->nullable();
            $table->enum('user_gender', ["male", "female", "other"])->nullable();
            $table->string('user_password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
