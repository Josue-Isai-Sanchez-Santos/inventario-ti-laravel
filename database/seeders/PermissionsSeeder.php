<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['nombre' => 'usuarios.ver', 'descripcion' => 'Ver módulo de usuarios'],
            ['nombre' => 'usuarios.crear', 'descripcion' => 'Crear usuarios'],
            ['nombre' => 'usuarios.editar', 'descripcion' => 'Editar usuarios'],
            ['nombre' => 'usuarios.eliminar', 'descripcion' => 'Eliminar usuarios'],

            ['nombre' => 'roles.ver', 'descripcion' => 'Ver módulo de roles'],
            ['nombre' => 'roles.crear', 'descripcion' => 'Crear roles'],
            ['nombre' => 'roles.editar', 'descripcion' => 'Editar roles'],
            ['nombre' => 'roles.eliminar', 'descripcion' => 'Eliminar roles'],

            ['nombre' => 'activos.ver', 'descripcion' => 'Ver módulo de activos'],
            ['nombre' => 'activos.crear', 'descripcion' => 'Crear activos'],
            ['nombre' => 'activos.editar', 'descripcion' => 'Editar activos'],
            ['nombre' => 'activos.eliminar', 'descripcion' => 'Eliminar activos'],

            ['nombre' => 'asignaciones.ver', 'descripcion' => 'Ver asignaciones'],
            ['nombre' => 'asignaciones.crear', 'descripcion' => 'Crear asignaciones'],
            ['nombre' => 'asignaciones.editar', 'descripcion' => 'Editar asignaciones'],
            ['nombre' => 'asignaciones.eliminar', 'descripcion' => 'Eliminar asignaciones'],

            ['nombre' => 'mantenimientos.ver', 'descripcion' => 'Ver mantenimientos'],
            ['nombre' => 'mantenimientos.crear', 'descripcion' => 'Crear mantenimientos'],
            ['nombre' => 'mantenimientos.editar', 'descripcion' => 'Editar mantenimientos'],
            ['nombre' => 'mantenimientos.eliminar', 'descripcion' => 'Eliminar mantenimientos'],

            ['nombre' => 'bajas.ver', 'descripcion' => 'Ver bajas'],
            ['nombre' => 'bajas.crear', 'descripcion' => 'Crear bajas'],
            ['nombre' => 'bajas.editar', 'descripcion' => 'Editar bajas'],
            ['nombre' => 'bajas.eliminar', 'descripcion' => 'Eliminar bajas'],

            ['nombre' => 'categorias.ver', 'descripcion' => 'Ver categorías'],
            ['nombre' => 'categorias.crear', 'descripcion' => 'Crear categorías'],
            ['nombre' => 'categorias.editar', 'descripcion' => 'Editar categorías'],
            ['nombre' => 'categorias.eliminar', 'descripcion' => 'Eliminar categorías'],

            ['nombre' => 'ubicaciones.ver', 'descripcion' => 'Ver ubicaciones'],
            ['nombre' => 'ubicaciones.crear', 'descripcion' => 'Crear ubicaciones'],
            ['nombre' => 'ubicaciones.editar', 'descripcion' => 'Editar ubicaciones'],
            ['nombre' => 'ubicaciones.eliminar', 'descripcion' => 'Eliminar ubicaciones'],

            ['nombre' => 'auditoria.ver', 'descripcion' => 'Ver auditoría'],
            ['nombre' => 'reportes.ver', 'descripcion' => 'Ver reportes'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['nombre' => $permission['nombre']],
                [
                    'descripcion' => $permission['descripcion'],
                    'activo' => true,
                ]
            );
        }

        $admin = Role::where('nombre', 'Administrador')->first();

        if ($admin) {
            $admin->permissions()->sync(
                Permission::query()->pluck('id_permission')->toArray()
            );
        }
    }
}
