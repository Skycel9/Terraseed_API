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
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perm_id');
            $table->foreignId('role_id');

            $table->foreign('perm_id')->references('id')->on('permissions')->onDelete(null);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_permissions');
    }
};
