<?php

namespace App\Models;

use App\Support\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $primaryKey = 'id_asignacion';

    public $timestamps = false;

    protected $fillable = [
        'activo_id',
        'responsable_id',
        'ubicacion_id',
        'fecha_asignacion',
        'fecha_retorno',
        'observaciones',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'fecha_asignacion' => 'datetime',
            'fecha_retorno' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function activo(): BelongsTo
    {
        return $this->belongsTo(Activo::class, 'activo_id', 'id_activo');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id', 'id');
    }

    public function ubicacion(): BelongsTo
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id', 'id_ubicacion');
    }

    public function isVigente(): bool
    {
        return $this->fecha_retorno === null;
    }

    protected static function booted(): void
    {
        static::deleted(function ($model) {
            Auditoria::registrar(
                'DELETE',
                'asignaciones',
                $model->id_asignacion,
                $model->toArray(),
                null
            );
        });
    }
}
