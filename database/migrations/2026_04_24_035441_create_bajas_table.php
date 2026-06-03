<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bajas', function (Blueprint $table) {
            $table->id('id_baja');
            $table->unsignedBigInteger('activo_id')->unique();
            $table->date('fecha');
            $table->string('motivo', 150);
            $table->text('detalle')->nullable();
            $table->unsignedBigInteger('autorizado_por_id')->nullable();
            $table->text('documento_url')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('activo_id')->references('id_activo')->on('activos');
            $table->foreign('autorizado_por_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bajas');
    }
};
