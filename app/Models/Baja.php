<?php

namespace App\Models;

use App\Support\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Baja extends Model
{
    protected $table = 'bajas';

    protected $primaryKey = 'id_baja';

    public $timestamps = false;

    protected $fillable = [
        'activo_id',
        'fecha',
        'motivo',
        'detalle',
        'autorizado_por_id',
        'documento_url',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function activo(): BelongsTo
    {
        return $this->belongsTo(Activo::class, 'activo_id', 'id_activo');
    }

    public function autorizadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autorizado_por_id', 'id');
    }

    protected static function booted(): void
    {
        static::deleted(function ($model) {
            Auditoria::registrar(
                'DELETE',
                'bajas',
                $model->id_baja,
                $model->toArray(),
                null
            );
        });
    }
}
