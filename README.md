# Sistema de Inventario de Activos TI

Sistema web desarrollado para registrar, consultar y administrar activos tecnológicos e institucionales. La aplicación permite mantener trazabilidad sobre el estado, ubicación, responsable, mantenimiento, licencias y baja de cada activo.

El proyecto fue desarrollado como parte de una residencia profesional de la carrera de Ingeniería en Sistemas Computacionales.

## Descripción general

El sistema centraliza la información de inventario que anteriormente podía encontrarse dispersa o registrarse de forma manual. Cada activo cuenta con un identificador único y puede asociarse con un código QR para facilitar su consulta.

La aplicación incluye un panel administrativo privado y una vista pública limitada para consulta mediante QR. La información sensible permanece restringida al personal autorizado.

## Funcionalidades principales

* Registro, consulta y edición de activos.
* Clasificación de activos por categorías.
* Gestión de estados del activo.
* Asignación de responsables y ubicaciones.
* Historial de asignaciones y devoluciones.
* Registro de mantenimientos preventivos y correctivos.
* Asociación de técnicos internos o externos.
* Registro de costos, resultados y comprobantes de mantenimiento.
* Gestión de licencias asociadas a activos.
* Control de vigencia, vencimiento y cancelación de licencias.
* Registro de bajas con motivo, autorización y evidencia.
* Generación de códigos QR individuales.
* Consulta pública limitada mediante QR.
* Control de usuarios, roles y permisos.
* Registro de auditoría y trazabilidad.
* Exportación de reportes generales y reportes de auditoría en formato PDF.

## Módulos del sistema

| Módulo           | Descripción                                                     |
| ---------------- | --------------------------------------------------------------- |
| Usuarios         | Administración de cuentas de acceso al sistema.                 |
| Roles y permisos | Control de privilegios según el tipo de usuario.                |
| Activos          | Registro de información técnica, fotografía y código QR.        |
| Categorías       | Clasificación de activos por tipo.                              |
| Ubicaciones      | Administración de áreas y espacios institucionales.             |
| Asignaciones     | Registro de responsables, ubicaciones y fechas de retorno.      |
| Licencias        | Gestión de software y vigencias asociadas a activos.            |
| Mantenimientos   | Seguimiento de intervenciones preventivas y correctivas.        |
| Bajas            | Registro formal de activos retirados de operación.              |
| Auditoría        | Historial de operaciones realizadas por los usuarios.           |
| Reportes         | Resumen general del inventario y exportación de documentos PDF. |

## Tecnologías utilizadas

| Tecnología     | Uso dentro del proyecto                                               |
| -------------- | --------------------------------------------------------------------- |
| PHP            | Lenguaje principal del backend.                                       |
| Laravel        | Framework para el desarrollo de la aplicación web.                    |
| Filament       | Panel administrativo y componentes de interfaz.                       |
| PostgreSQL     | Sistema de gestión de base de datos relacional.                       |
| Docker Compose | Contenedor local para PostgreSQL.                                     |
| Blade          | Motor de plantillas para las vistas.                                  |
| Tailwind CSS   | Estilos de interfaz.                                                  |
| Nginx          | Servidor web utilizado en producción.                                 |
| Amazon EC2     | Servidor virtual utilizado para desplegar la aplicación.              |
| Amazon RDS     | Servicio administrado utilizado para alojar PostgreSQL en producción. |
| Git y GitHub   | Control de versiones y respaldo del código fuente.                    |

## Arquitectura general

La aplicación sigue una arquitectura cliente-servidor.

```text
Cliente web
    |
    v
Aplicación Laravel + Filament
    |
    v
Base de datos PostgreSQL
```

En el despliegue realizado en AWS:

```text
Navegador web
    |
    v
Amazon EC2 + Nginx + PHP
    |
    v
Amazon RDS PostgreSQL
```

## Requisitos para ejecución local

Antes de instalar el proyecto, se requiere:

* PHP 8.2 o superior.
* Composer.
* Node.js y npm.
* Docker.
* Docker Compose.
* Git.

## Instalación local

### 1. Clonar el repositorio

```bash
git clone https://github.com/Josue-Isai-Sanchez-Santos/inventario-ti-laravel.git
cd inventario-ti-laravel
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Crear el archivo de configuración local

```bash
cp .env.example .env
```

### 4. Generar la clave de Laravel

```bash
php artisan key:generate
```

### 5. Iniciar PostgreSQL mediante Docker Compose

```bash
docker compose up -d
```

### 6. Ejecutar las migraciones

```bash
php artisan migrate
```

### 7. Cargar los permisos iniciales

```bash
php artisan db:seed --class=PermissionsSeeder
```

### 8. Crear el enlace para archivos públicos

```bash
php artisan storage:link
```

### 9. Instalar dependencias del frontend

```bash
npm install
npm run build
```

### 10. Crear un usuario administrativo

```bash
php artisan make:filament-user
```

### 11. Iniciar el servidor local

```bash
php artisan serve
```

La aplicación estará disponible normalmente en:

```text
http://127.0.0.1:8000
```

El panel administrativo se encuentra en:

```text
http://127.0.0.1:8000/admin
```

## Variables de entorno

El archivo `.env.example` contiene valores genéricos para ejecución local.

Las credenciales reales deben mantenerse únicamente en `.env`, archivo que está excluido del repositorio mediante `.gitignore`.

Ejemplo de configuración local para PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=inventario
DB_USERNAME=inventario_user
DB_PASSWORD=inventario_pass
```

La contraseña mostrada es exclusivamente para desarrollo local. No debe reutilizarse en un entorno de producción.

## Base de datos

El esquema de PostgreSQL se encuentra documentado en:

```text
docs/database/bd_inventario_schema.sql
```

El archivo contiene la estructura de tablas, relaciones, llaves foráneas e índices, sin incluir registros operativos ni credenciales.

Entre las tablas principales se encuentran:

```text
users
roles
user_roles
permissions
role_permissions
categorias
ubicaciones
estados_activo
estados_licencia
activos
asignaciones
licencias
mantenimientos
bajas
auditoria_eventos
```

## Consulta mediante código QR

Cada activo puede generar una ficha PDF con código QR. Al escanearlo, el sistema muestra únicamente información pública autorizada, como:

* Nombre del activo.
* Marca.
* Ubicación general.
* Fotografía.
* Estado general.

Los datos administrativos, económicos, técnicos y de auditoría permanecen restringidos al panel privado.

## Seguridad

El repositorio no debe incluir:

* Archivos `.env`.
* Contraseñas.
* Claves privadas `.pem`.
* Tokens de acceso.
* Credenciales de AWS.
* Credenciales de Amazon RDS.
* Comprobantes o documentos operativos.
* Fotografías cargadas durante las pruebas.
* Códigos QR generados dinámicamente.

Las reglas correspondientes se encuentran definidas en `.gitignore`.

## Despliegue

El sistema fue desplegado en un entorno de nube utilizando:

* Amazon EC2 para alojar la aplicación.
* Nginx como servidor web.
* PHP-FPM para procesar la aplicación Laravel.
* Amazon RDS para alojar PostgreSQL.
* Elastic IP para mantener una dirección pública estable durante las pruebas de despliegue.

Las credenciales y direcciones del entorno de producción no se incluyen en este repositorio.

## Autor

**Josué Isaí Sanchez Santos**
Ingeniería en Sistemas Computacionales
2026

## Nota

Este repositorio contiene el código fuente y la documentación técnica del proyecto. Los datos operativos utilizados durante las pruebas no forman parte del repositorio.


## Licencia

Este proyecto se distribuye bajo la licencia MIT. Consulta el archivo [LICENSE](LICENSE) para obtener más información.
