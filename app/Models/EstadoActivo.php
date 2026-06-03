<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoActivo extends Model
{
    protected $table = 'estados_activo';

    protected $primaryKey = 'id_estado';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function activos(): HasMany
    {
        return $this->hasMany(Activo::class, 'estado_id', 'id_estado');
    }
}
