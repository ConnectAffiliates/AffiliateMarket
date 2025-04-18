<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignUuid('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->foreignUuid('role_id')->constrained('roles')->cascadeOnDelete();
            $table->primary(['permission_id', 'role_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_role');
    }
};