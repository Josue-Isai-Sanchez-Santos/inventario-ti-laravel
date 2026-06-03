<?php

namespace App\Models;

use App\Support\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Licencia extends Model
{
    protected $table = 'licencias';

    protected $primaryKey = 'id_licencia';

    protected $fillable = [
        'activo_id',
        'tipo',
        'proveedor',
        'clave',
        'fecha_inicio',
        'fecha_fin',
        'archivo_url',
        'estado_lic_id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function activo(): BelongsTo
    {
        return $this->belongsTo(Activo::class, 'activo_id', 'id_activo');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoLicencia::class, 'estado_lic_id', 'id_estado_lic');
    }

    protected static function booted(): void
    {
        static::deleted(function ($model) {
            Auditoria::registrar(
                'DELETE',
                'licencias',
                $model->id_licencia,
                $model->toArray(),
                null
            );
        });
    }
}
