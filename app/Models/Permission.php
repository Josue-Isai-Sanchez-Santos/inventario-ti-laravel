<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $primaryKey = 'id_permission';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'created_at',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions',
            'permission_id',
            'rol_id',
            'id_permission',
            'id_rol'
        )->withPivot('assigned_at');
    }
}
