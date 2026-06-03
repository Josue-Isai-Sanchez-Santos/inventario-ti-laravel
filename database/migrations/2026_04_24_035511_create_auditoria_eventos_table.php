<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditoria_eventos', function (Blueprint $table) {
            $table->id('id_evento');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->string('accion', 50);
            $table->string('tabla', 100);
            $table->unsignedBigInteger('registro_id');
            $table->text('antes')->nullable();
            $table->text('despues')->nullable();
            $table->string('ip', 50)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria_eventos');
    }
};
