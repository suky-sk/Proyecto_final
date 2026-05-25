# Proyecto Concesionario

Aplicacion Laravel 10 con MariaDB y datos iniciales del concesionario.

## Arranque

```bash
docker compose up -d
```

Despues abre:

```text
http://localhost:8000
```

La primera vez Docker instala dependencias, compila los assets, crea MariaDB, ejecuta migraciones y carga `database/seeders/data/concesionario.sql`.

## Comandos utiles

```bash
docker compose logs -f app
docker compose down
docker compose down -v
```

`docker compose down -v` borra la base de datos del contenedor. Al volver a ejecutar `docker compose up -d`, se cargan otra vez los datos iniciales.

## Estructura principal

- `app/Http/Controllers`: controladores.
- `app/Models`: modelos.
- `resources/views`: vistas Blade.
- `database/migrations`: estructura de la base de datos.
- `database/seeders/data/concesionario.sql`: datos iniciales.
- `docker-compose.yml`: app, Vite y MariaDB.
