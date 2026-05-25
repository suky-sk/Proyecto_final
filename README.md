# Proyecto final - Concesionario

Aplicacion web de concesionario hecha con Laravel. Permite ver un catalogo de coches, filtrar por marca, precio o modelo, ver la ficha de cada vehiculo, registrarse, iniciar sesion, editar el perfil, usar un carrito y gestionar usuarios/coches desde un panel de administrador.

El proyecto esta preparado para levantarse entero con Docker: aplicacion Laravel, base de datos MariaDB, migraciones, datos iniciales y fotos.

## Requisitos

- Git
- Docker Desktop o Docker Engine
- Docker Compose

No hace falta instalar PHP, Composer, Node, NPM ni MariaDB en el ordenador. Docker se encarga de todo.

## Instalacion en un PC nuevo

1. Clonar el repositorio:

```bash
git clone https://github.com/suky-sk/Proyecto_final.git
```

2. Entrar en la carpeta del proyecto:

```bash
cd Proyecto_final
```

3. Levantar el proyecto:

```bash
docker compose up -d --build
```

4. Abrir la pagina:

```text
http://localhost:8000
```

La primera vez puede tardar un poco porque Docker descarga las imagenes, instala dependencias, compila los assets y prepara la base de datos.

## Base de datos

No hay que importar el SQL a mano.

Al levantar el proyecto, el contenedor de Laravel espera a que MariaDB este lista y ejecuta automaticamente:

```bash
php artisan migrate --seed --force
```

Eso crea las tablas y carga los datos del archivo:

```text
database/seeders/data/concesionario.sql
```

Tambien se crea el enlace de `storage` para que las fotos se vean desde la web.

### Resetear la base de datos

Si quieres borrar la base de datos del contenedor y volver a empezar desde el SQL original:

```bash
docker compose down -v
docker compose up -d --build
```

Importante: los datos del proyecto se vuelven a cargar desde el dump cuando arranca el contenedor de la aplicacion. Esto esta hecho asi para que en cualquier PC el proyecto arranque siempre con los mismos coches, usuarios y compras de ejemplo.

## Usuarios de prueba

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

Tambien se puede crear un usuario nuevo desde `/registro`.

## Comandos utiles

Levantar o reconstruir el proyecto:

```bash
docker compose up -d --build
```

Ver logs de Laravel:

```bash
docker compose logs -f app
```

Parar los contenedores:

```bash
docker compose down
```

Parar y borrar tambien la base de datos guardada en Docker:

```bash
docker compose down -v
```

Ver las rutas de Laravel:

```bash
docker compose exec app php artisan route:list
```

## Que hace el proyecto

- Muestra los coches disponibles en la pagina principal.
- Permite filtrar por marca, rango de precio y texto de busqueda.
- Muestra una ficha individual para cada coche.
- Permite registrarse e iniciar sesion.
- Permite modificar los datos del perfil.
- Permite anadir coches al carrito y finalizar una compra.
- Resta stock al comprar.
- Guarda las compras en la tabla intermedia `coche_usuario`.
- Tiene un panel de administrador para gestionar coches y usuarios.
- Usa fotos reales guardadas dentro del propio proyecto.

## Archivos propios del proyecto

Esta lista explica solo los archivos importantes que se han hecho o adaptado para este proyecto. Los archivos normales que trae Laravel por defecto no se detallan aqui.

### Docker

`docker-compose.yml`

Define los dos contenedores del proyecto:

- `app`: contenedor de Laravel.
- `db`: contenedor de MariaDB.

Tambien abre la web en `localhost:8000` y la base de datos en el puerto local `3307`.

`Dockerfile`

Construye la imagen de Laravel. Instala PHP con las extensiones necesarias, Composer, Node y NPM. Despues instala dependencias, compila los assets de Vite y deja la aplicacion lista para arrancar.

`docker/app-entrypoint.sh`

Script que se ejecuta cada vez que arranca el contenedor `app`. Hace estas tareas:

- Comprueba que exista `APP_KEY`.
- Espera a que MariaDB este disponible.
- Ejecuta migraciones y seeders.
- Crea el enlace publico a `storage`.
- Arranca Laravel en el puerto `8000`.

`docker/laravel.env`

Variables de entorno que usa Laravel dentro de Docker: nombre de la app, clave, conexion a MariaDB, usuario, password y modo debug.

### Rutas

`routes/web.php`

Contiene todas las rutas web del proyecto:

- Inicio y ficha de coches.
- Registro, login y logout.
- Perfil de usuario.
- Carrito.
- Panel de administrador.

### Controladores

`app/Http/Controllers/ConcesionarioController.php`

Controla la pagina principal y la ficha de cada coche. Aplica filtros por marca, precio y modelo. Tambien localiza las fotos de cada coche dentro de `storage/app/public/Fotos`.

`app/Http/Controllers/LoginController.php`

Controla registro, inicio de sesion y cierre de sesion. Al registrarse, guarda el usuario con la contrasena cifrada e inicia sesion automaticamente.

`app/Http/Controllers/ProfileController.php`

Muestra y actualiza los datos del perfil del usuario autenticado.

`app/Http/Controllers/CarritoController.php`

Gestiona el carrito en sesion. Permite anadir coches, quitar coches y finalizar la compra. Al comprar, descuenta stock y guarda la compra en `coche_usuario`.

`app/Http/Controllers/AdminCocheController.php`

Gestiona los coches desde el panel de administrador. Permite listar, crear, editar y eliminar coches. Tambien guarda las fotos subidas en la carpeta del coche correspondiente.

`app/Http/Controllers/AdminUsuarioController.php`

Gestiona usuarios desde el panel de administrador. Permite listar, editar y eliminar usuarios. Evita que un administrador se borre a si mismo.

`app/Http/Middleware/EsAdmin.php`

Middleware que protege las rutas de administracion. Solo deja pasar a usuarios con `es_admin = true`.

### Modelos

`app/Models/Coche.php`

Modelo de la tabla `coche`. Define los campos editables, el borrado logico, la relacion con `Marca` y la relacion muchos a muchos con `Usuario`.

`app/Models/Marca.php`

Modelo de la tabla `marca`. Una marca puede tener muchos coches.

`app/Models/Usuario.php`

Modelo de la tabla `usuario`. Se usa para autenticacion. La contrasena real esta guardada en el campo `contrasena`. Tambien define la relacion con los coches comprados.

### Base de datos

`database/migrations/2025_12_05_080500_create_marca_table.php`

Crea la tabla `marca`.

`database/migrations/2025_12_05_080600_create_coche_table.php`

Crea la tabla `coche`, relacionada con `marca`.

`database/migrations/2025_12_05_083621_create_usuario_table.php`

Crea la tabla `usuario`.

`database/migrations/2025_12_05_092140_create_coche_usuario_table.php`

Crea la tabla intermedia `coche_usuario`, donde se guardan las compras de usuarios.

`database/seeders/DatabaseSeeder.php`

Archivo de entrada de los seeders. Lo dejamos apuntando a `ConcesionarioDumpSeeder` para cargar los datos del concesionario.

`database/seeders/ConcesionarioDumpSeeder.php`

Lee el dump SQL del proyecto, vacia las tablas principales y carga los datos en orden correcto para respetar las claves foraneas.

`database/seeders/data/concesionario.sql`

Dump con los datos iniciales: marcas, coches, usuarios y compras de ejemplo.

### Vistas

`resources/views/layouts/app.blade.php`

Plantilla base de la web. Incluye estructura HTML, menu, estilos y scripts.

`resources/views/welcome.blade.php`

Pagina principal del concesionario. Muestra catalogo, filtros y tarjetas de coches.

`resources/views/coches/show.blade.php`

Ficha individual de un coche.

`resources/views/login.blade.php`

Formulario de inicio de sesion.

`resources/views/register.blade.php`

Formulario de registro.

`resources/views/profile.blade.php`

Pantalla de perfil del usuario.

`resources/views/cart.blade.php`

Pantalla del carrito.

`resources/views/admin/coches/index.blade.php`

Panel de administrador para crear, editar y eliminar coches.

`resources/views/admin/usuarios/index.blade.php`

Listado de usuarios para administradores.

`resources/views/admin/usuarios/edit.blade.php`

Formulario de edicion de usuarios para administradores.

### Estilos, JavaScript y fotos

`resources/css/app.css`

Estilos principales de la aplicacion.

`resources/js/app.js`

JavaScript del proyecto. Controla los botones de imagen anterior/siguiente para recorrer las fotos de cada coche.

`storage/app/public/Fotos`

Carpeta con las fotos de los coches. Esta carpeta va dentro del repositorio para que al clonar el proyecto en otro PC las imagenes ya esten disponibles.

Cada subcarpeta corresponde normalmente al id de un coche. Por ejemplo, las fotos del coche con id `27` estan en:

```text
storage/app/public/Fotos/27
```

## Resumen rapido

En otro ordenador, el proceso completo es:

```bash
git clone https://github.com/suky-sk/Proyecto_final.git
cd Proyecto_final
docker compose up -d --build
```

Y despues entrar en:

```text
http://localhost:8000
```
