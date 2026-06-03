<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id('id_asignacion');
            $table->unsignedBigInteger('activo_id');
            $table->unsignedBigInteger('responsable_id');
            $table->unsignedBigInteger('ubicacion_id');
            $table->timestamp('fecha_asignacion');
            $table->timestamp('fecha_retorno')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('activo_id')->references('id_activo')->on('activos');
            $table->foreign('responsable_id')->references('id')->on('users');
            $table->foreign('ubicacion_id')->references('id_ubicacion')->on('ubicaciones');
        });

        DB::statement('
            CREATE UNIQUE INDEX idx_asignacion_vigente
            ON asignaciones(activo_id)
            WHERE fecha_retorno IS NULL
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};
