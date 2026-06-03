<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->id('id_activo');
            $table->string('codigo_inventario', 50)->nullable()->unique();
            $table->string('nombre', 150);
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('estado_id');
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('serie', 100)->nullable()->unique();
            $table->text('descripcion')->nullable();
            $table->text('foto_url')->nullable();
            $table->date('fecha_compra')->nullable();
            $table->decimal('costo', 12, 2)->nullable();
            $table->string('qr_token', 100)->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('categoria_id')->references('id_categoria')->on('categorias');
            $table->foreign('estado_id')->references('id_estado')->on('estados_activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activos');
    }
};
