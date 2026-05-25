#!/bin/bash
set -e

PROJECT_DIR="/Users/admin2/Proyecto_final"
cd "$PROJECT_DIR"

echo "==> Verificando dependencias..."
command -v php >/dev/null || { echo "ERROR: PHP no instalado. Instala con: brew install php"; exit 1; }
command -v composer >/dev/null || { echo "ERROR: Composer no instalado. Instala con: brew install composer"; exit 1; }
command -v mysql >/dev/null || { echo "ERROR: MySQL no instalado. Instala con: brew install mysql"; exit 1; }

echo "==> Instalando dependencias PHP..."
composer install

if ! grep -q "APP_KEY=base64:" .env; then
  echo "==> Generando APP_KEY..."
  php artisan key:generate
fi

echo "==> Creando base de datos concesionario..."
mysql -u root -e "CREATE DATABASE IF NOT EXISTS concesionario CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || \
mysql -u root --password="" -e "CREATE DATABASE IF NOT EXISTS concesionario CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo "==> Ejecutando migraciones y seeders..."
php artisan migrate --seed --force

echo "==> Enlace simbolico storage..."
php artisan storage:link 2>/dev/null || true

echo ""
echo "Listo. Para arrancar el proyecto:"
echo "  Terminal 1: cd $PROJECT_DIR && php artisan serve"
echo "  Terminal 2: cd $PROJECT_DIR && npm run dev"
echo ""
echo "Abre: http://127.0.0.1:8000"
