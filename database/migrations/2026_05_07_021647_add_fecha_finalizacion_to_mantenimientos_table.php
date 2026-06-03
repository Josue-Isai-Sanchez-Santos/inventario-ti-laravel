<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mantenimientos', function (Blueprint $table) {
            $table->timestamp('fecha_finalizacion')->nullable()->after('fecha');
            $table->text('resultado')->nullable()->after('descripcion');
        });
    }

    public function down(): void
    {
        Schema::table('mantenimientos', function (Blueprint $table) {
            $table->dropColumn(['fecha_finalizacion', 'resultado']);
        });
    }
};
