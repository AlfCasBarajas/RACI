# Copilot Instructions for RACI

## Arquitectura y Estructura
- Proyecto PHP con patrón MVC: las carpetas principales son `app/controllers`, `app/models`, `app/views` y `app/core`.
- El archivo de entrada es `index.php` en la raíz, que inicializa la app y enruta a los controladores.
- `app/core/App.php` gestiona el ruteo y carga dinámica de controladores.
- `app/core/Database.php` centraliza la conexión PDO a MySQL.
- Las rutas de los `require_once` y `include` deben usar `__DIR__` para evitar errores de carga.

## Base de Datos y Seeders
- El archivo `db.sql` contiene la estructura y datos iniciales (roles y usuarios) para la base de datos MySQL.
- Los scripts `app/models/seed.php` y `app/models/usuarios_seed.php` insertan datos iniciales. Ejecutar primero los inserts de roles antes de los usuarios para evitar errores de clave foránea.
- El campo de contraseña en la tabla `user` es `contrasena` (sin ñ ni tildes).
- Las contraseñas deben estar encriptadas usando `password_hash` de PHP.

## Convenciones y Patrones
- Los controladores extienden de `app/core/Controller.php`.
- Las vistas se incluyen desde los controladores usando rutas relativas a partir de `__DIR__`.
- El login redirige usando URLs web, no rutas de sistema de archivos.
- Los nombres de columnas y archivos evitan tildes y ñ para compatibilidad.
- Los roles y permisos están definidos en la tabla `rol` y se usan como claves foráneas en `user`.

## Flujos y Comandos Clave
- Para poblar la base de datos: importar `db.sql` en MySQL.
- Para poblar datos desde PHP: ejecutar `php app/models/seed.php` o `php app/models/usuarios_seed.php`.
- Para iniciar la app: acceder a `index.php` desde el navegador (ej. http://localhost/RACI/).

## Ejemplo de Estructura de Carpeta
```
app/
  controllers/
    LoginController.php
  models/
    seed.php
    usuarios_seed.php
  views/
    login.php
    dashboard.php
  core/
    App.php
    Controller.php
    Database.php
index.php
db.sql
```

## Errores Comunes y Soluciones
- Si ves errores de clave foránea al insertar usuarios, asegúrate de que los roles existen primero.
- Si ves errores de rutas en `require_once` o `include`, usa siempre `__DIR__` para rutas absolutas.
- Si el login no redirige correctamente, revisa que la redirección sea a una URL web, no a una ruta local.

## Referencias
- Ver `README.md` para la descripción general del proyecto.
- Ver `db.sql` para la estructura y datos iniciales de la base de datos.
- Ver controladores y modelos en `app/` para ejemplos de patrones usados.
