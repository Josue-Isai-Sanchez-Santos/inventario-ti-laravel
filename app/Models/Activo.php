<?php

namespace App\Models;

use App\Support\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Activo extends Model
{
    protected $table = 'activos';

    protected $primaryKey = 'id_activo';

    public $timestamps = false;

    protected $fillable = [
        'codigo_inventario',
        'nombre',
        'categoria_id',
        'estado_id',
        'marca',
        'modelo',
        'serie',
        'descripcion',
        'foto_url',
        'fecha_compra',
        'costo',
        'qr_token',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'fecha_compra' => 'date',
            'costo' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoActivo::class, 'estado_id', 'id_estado');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(Asignacion::class, 'activo_id', 'id_activo');
    }

    public function mantenimientos(): HasMany
    {
        return $this->hasMany(Mantenimiento::class, 'activo_id', 'id_activo');
    }

    public function baja(): HasOne
    {
        return $this->hasOne(Baja::class, 'activo_id', 'id_activo');
    }

    public function getPublicUrlAttribute(): string
    {
        return rtrim(env('APP_PUBLIC_URL', config('app.url')), '/').'/a/'.$this->qr_token;
    }

    public function getQrImagePathAttribute(): string
    {
        return 'qrs/'.$this->qr_token.'.svg';
    }

    public function qrExiste(): bool
    {
        return file_exists(storage_path('app/public/'.$this->qr_image_path));
    }

    public function estaDadoDeBaja(): bool
    {
        return $this->estado()
            ->whereIn('nombre', ['Dado de baja', 'Baja'])
            ->exists();
    }

    public function estaEnMantenimiento(): bool
    {
        return $this->estado()
            ->where('nombre', 'En mantenimiento')
            ->exists();
    }

    public function licencias(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Licencia::class, 'activo_id', 'id_activo');
    }

    public function tieneAsignacionVigente(): bool
    {
        return $this->asignaciones()
            ->whereNull('fecha_retorno')
            ->exists();
    }

    protected static function booted(): void
    {
        static::deleted(function ($model) {
            Auditoria::registrar(
                'DELETE',
                'activos',
                $model->id_activo,
                $model->toArray(),
                null
            );
        });
    }
}
