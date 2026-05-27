# Proyecto final - Concesionario

Esta es una aplicación web de concesionario construida con Laravel. Aquí puedes navegar un catálogo de coches, filtrar por marca, precio y modelo, ver la ficha de cada vehículo, registrarte, iniciar sesión y comprar desde el carrito. Si tienes acceso de administrador, también puedes gestionar usuarios y coches.

El proyecto está pensado para funcionar con Docker, así no necesitas PHP, Composer, Node o MariaDB instalados en tu equipo.

## Qué necesitas

- Git
- Docker Desktop o Docker Engine
- Docker Compose

Eso es todo. El resto lo maneja Docker dentro del contenedor.

## Cómo arrancarlo en una máquina nueva

1. Clona el repositorio:

```bash
git clone https://github.com/suky-sk/Proyecto_final.git
```

2. Entra en la carpeta del proyecto:

```bash
cd Proyecto_final
```

3. Arranca todo con Docker:

```bash
docker compose up -d --build
```

4. Abre la app en el navegador:

```text
http://localhost:8000
```

La primera vez puede tardar un poco porque Docker está descargando imágenes, instalando dependencias, compilando assets y preparando la base de datos.

## Qué hace Docker por ti

No necesitas importar ningún SQL manualmente.

Al arrancar el contenedor de Laravel, el proyecto espera a que la base de datos MariaDB esté lista y ejecuta automáticamente:

```bash
php artisan migrate --seed --force
```

Con eso se crean las tablas y se cargan los datos desde:

```text
database/seeders/data/concesionario.sql
```

También se crea el enlace de `storage` para que las fotos de los coches se vean correctamente.

### Si quieres empezar de cero

Si necesitas borrar la base de datos del contenedor y volver a arrancar con los datos originales, usa:

```bash
docker compose down -v
docker compose up -d --build
```

Esto deja el proyecto limpio y lo vuelve a iniciar con los coches, usuarios y compras que vienen en el dump.

## Usuarios de prueba

Puedes entrar con estas cuentas de ejemplo:

Administrador:

```text
Email: GonzF@gmail.com
Password: 1234
```

Usuario normal:

```text
Email: Ferran@visma.com
Password: 1234
```

También puedes crear una cuenta nueva desde `/registro`.

## Comandos útiles

Arrancar o reconstruir el proyecto:

```bash
docker compose up -d --build
```

Ver los logs de Laravel:

```bash
docker compose logs -f app
```

Detener los contenedores:

```bash
docker compose down
```

Detener y borrar también la base de datos:

```bash
docker compose down -v
```

Ver las rutas de Laravel:

```bash
docker compose exec app php artisan route:list
```

## Qué hace esta app

- Muestra el catálogo de coches en la página principal.
- Permite filtrar por marca, rango de precio y búsqueda de texto.
- Muestra una ficha detallada de cada coche.
- Permite registrarse e iniciar sesión.
- Permite editar los datos del perfil.
- Tiene un carrito de compras y un proceso de compra.
- Resta stock cuando se compra un coche.
- Guarda las compras en la tabla `coche_usuario`.
- Incluye un panel de administrador para gestionar coches y usuarios.
- Usa fotos guardadas directamente en el proyecto.

## Archivos clave del proyecto

Aquí están los archivos principales que se han adaptado para este proyecto. No listamos los archivos estándar que trae Laravel por defecto.

### Docker

- `docker-compose.yml`: define los contenedores `app` y `db`. Expone la aplicación en `localhost:8000` y la base de datos en el puerto local `3307`.
- `Dockerfile`: construye la imagen de Laravel, instala PHP, extensiones, Composer, Node y NPM, instala dependencias y compila assets.
- `docker/app-entrypoint.sh`: script que se ejecuta al iniciar el contenedor de Laravel. Espera a la base de datos, ejecuta migraciones y seeders, crea el enlace a `storage` y arranca la aplicación.
- `docker/laravel.env`: variables de entorno usadas por Laravel dentro del contenedor.

### Rutas

- `routes/web.php`: define las rutas de la aplicación: inicio, ficha de coches, registro, login, perfil, carrito y administración.

### Controladores

- `app/Http/Controllers/ConcesionarioController.php`: gestiona la página principal y las fichas de coche, incluyendo filtros y búsqueda.
- `app/Http/Controllers/LoginController.php`: controla el registro, el inicio de sesión y el logout.
- `app/Http/Controllers/ProfileController.php`: muestra y actualiza los datos del usuario autenticado.
- `app/Http/Controllers/CarritoController.php`: gestiona el carrito, la eliminación de productos y la compra.
- `app/Http/Controllers/AdminCocheController.php`: administra coches desde el panel de admin.
- `app/Http/Controllers/AdminUsuarioController.php`: administra usuarios desde el panel de admin.
- `app/Http/Middleware/EsAdmin.php`: protege las rutas de administración para que solo puedan acceder administradores.

### Modelos

- `app/Models/Coche.php`: modelo del coche, relaciones con marca y con usuarios.
- `app/Models/Marca.php`: modelo de marca.
- `app/Models/Usuario.php`: modelo de usuario, con la contraseña en el campo `contrasena`.

### Base de datos

- `database/migrations/2025_12_05_080500_create_marca_table.php`: crea la tabla `marca`.
- `database/migrations/2025_12_05_080600_create_coche_table.php`: crea la tabla `coche`.
- `database/migrations/2025_12_05_083621_create_usuario_table.php`: crea la tabla `usuario`.
- `database/migrations/2025_12_05_092140_create_coche_usuario_table.php`: crea la tabla intermedia `coche_usuario`.
- `database/seeders/DatabaseSeeder.php`: ejecuta el seeder principal.
- `database/seeders/ConcesionarioDumpSeeder.php`: carga los datos del dump SQL.
- `database/seeders/data/concesionario.sql`: contiene los datos iniciales.

### Vistas importantes

- `resources/views/layouts/app.blade.php`: plantilla base.
- `resources/views/welcome.blade.php`: página principal.
- `resources/views/coches/show.blade.php`: ficha de coche.
- `resources/views/login.blade.php`: formulario de inicio de sesión.
- `resources/views/register.blade.php`: formulario de registro.
- `resources/views/profile.blade.php`: perfil de usuario.
- `resources/views/cart.blade.php`: carrito de compras.
- `resources/views/admin/coches/index.blade.php`: administración de coches.
- `resources/views/admin/usuarios/index.blade.php`: administración de usuarios.
- `resources/views/admin/usuarios/edit.blade.php`: edición de usuarios.

### Estilos, JavaScript y fotos

- `resources/css/app.css`: estilos principales.
- `resources/js/app.js`: controla los botones e interacciones de la interfaz.
- `storage/app/public/Fotos`: fotos de los coches dentro del proyecto.

Cada carpeta de `storage/app/public/Fotos` suele corresponder con el ID del coche. Por ejemplo:

```text
storage/app/public/Fotos/27
```

## Resumen rápido

Para abrir el proyecto en otra máquina:

```bash
git clone https://github.com/suky-sk/Proyecto_final.git
cd Proyecto_final
docker compose up -d --build
```

Después, abre:

```text
http://localhost:8000
```
