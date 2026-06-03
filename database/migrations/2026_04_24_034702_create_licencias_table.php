<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licencias', function (Blueprint $table) {
            $table->id('id_licencia');
            $table->unsignedBigInteger('activo_id');
            $table->string('tipo', 100);
            $table->string('proveedor', 150)->nullable();
            $table->string('clave', 150)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->text('archivo_url')->nullable();
            $table->unsignedBigInteger('estado_lic_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('activo_id')->references('id_activo')->on('activos');
            $table->foreign('estado_lic_id')->references('id_estado_lic')->on('estados_licencia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licencias');
    }
};
