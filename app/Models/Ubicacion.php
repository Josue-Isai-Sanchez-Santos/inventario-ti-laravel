<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';

    protected $primaryKey = 'id_ubicacion';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'activa',
    ];

    public function asignaciones(): HasMany
    {
        return $this->hasMany(Asignacion::class, 'ubicacion_id', 'id_ubicacion');
    }
}
