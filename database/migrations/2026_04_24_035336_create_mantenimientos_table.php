<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id('id_mantenimiento');
            $table->unsignedBigInteger('activo_id');
            $table->timestamp('fecha');
            $table->string('tipo', 50);
            $table->string('proveedor', 150)->nullable();
            $table->unsignedBigInteger('tecnico_id')->nullable();
            $table->string('tecnico_externo', 150)->nullable();
            $table->text('descripcion');
            $table->decimal('costo', 12, 2)->nullable();
            $table->text('comprobante_url')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('activo_id')->references('id_activo')->on('activos');
            $table->foreign('tecnico_id')->references('id')->on('users');
        });

        DB::statement('
            ALTER TABLE mantenimientos
            ADD CONSTRAINT chk_tecnico
            CHECK (tecnico_id IS NOT NULL OR tecnico_externo IS NOT NULL)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
