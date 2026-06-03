<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'activo',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'activo' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'user_roles',
            'user_id',
            'rol_id',
            'id',
            'id_rol'
        )->withPivot('assigned_at');
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'responsable_id', 'id');
    }

    public function mantenimientosTecnico()
    {
        return $this->hasMany(Mantenimiento::class, 'tecnico_id', 'id');
    }

    public function bajasAutorizadas()
    {
        return $this->hasMany(Baja::class, 'autorizado_por_id', 'id');
    }

    public function hasRole(string $roleName): bool
    {
        return $this->roles()
            ->where('nombre', $roleName)
            ->exists();
    }

    public function hasPermission(string $permissionName): bool
    {
        if ($this->hasRole('Administrador')) {
            return true;
        }

        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissionName) {
                $query->where('nombre', $permissionName)
                    ->where('activo', true);
            })
            ->exists();
    }
}
