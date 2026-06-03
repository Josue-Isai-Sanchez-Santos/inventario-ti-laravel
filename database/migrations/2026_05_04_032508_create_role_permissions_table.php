<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamp('assigned_at')->useCurrent();

            $table->primary(['rol_id', 'permission_id']);

            $table->foreign('rol_id')
                ->references('id_rol')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id_permission')
                ->on('permissions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
