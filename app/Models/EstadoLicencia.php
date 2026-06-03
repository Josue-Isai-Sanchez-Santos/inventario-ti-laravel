<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoLicencia extends Model
{
    protected $table = 'estados_licencia';

    protected $primaryKey = 'id_estado_lic';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function licencias(): HasMany
    {
        return $this->hasMany(Licencia::class, 'estado_lic_id', 'id_estado_lic');
    }
}
