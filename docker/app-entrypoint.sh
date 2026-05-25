#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

if [ -z "${APP_KEY:-}" ]; then
  echo "Falta APP_KEY. Revisa docker/laravel.env."
  exit 1
fi

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
find storage bootstrap/cache -type d -exec chmod 775 {} \; || true
find storage bootstrap/cache -type f -exec chmod 664 {} \; || true

echo "Esperando a MariaDB en ${DB_HOST}:${DB_PORT}..."
until php -r '
try {
    new PDO(
        "mysql:host=" . getenv("DB_HOST") . ";port=" . getenv("DB_PORT") . ";dbname=" . getenv("DB_DATABASE"),
        getenv("DB_USERNAME"),
        getenv("DB_PASSWORD")
    );
    exit(0);
} catch (Throwable $e) {
    exit(1);
}
'; do
  sleep 2
done

php artisan migrate --seed --force

if [ ! -L public/storage ]; then
  php artisan storage:link || true
fi

exec php artisan serve --host=0.0.0.0 --port=8000
