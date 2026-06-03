<?php

namespace App\Models;

use App\Support\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';

    protected $primaryKey = 'id_mantenimiento';

    public $timestamps = false;

    protected $fillable = [
        'activo_id',
        'fecha',
        'tipo',
        'proveedor',
        'tecnico_id',
        'tecnico_externo',
        'descripcion',
        'costo',
        'comprobante_url',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'fecha_finalizacion' => 'datetime',
            'costo' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function activo(): BelongsTo
    {
        return $this->belongsTo(Activo::class, 'activo_id', 'id_activo');
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id', 'id');
    }

    protected static function booted(): void
    {
        static::deleted(function ($model) {
            Auditoria::registrar(
                'DELETE',
                'mantenimientos',
                $model->id_mantenimiento,
                $model->toArray(),
                null
            );
        });
    }
}
