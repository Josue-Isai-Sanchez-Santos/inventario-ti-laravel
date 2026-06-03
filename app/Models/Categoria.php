<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $primaryKey = 'id_categoria';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activa',
    ];

    public function activos(): HasMany
    {
        return $this->hasMany(Activo::class, 'categoria_id', 'id_categoria');
    }
}
