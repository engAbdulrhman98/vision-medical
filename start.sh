#!/bin/bash
set -e

echo "=== Vision Medical - Starting up ==="
echo "PORT: ${PORT:-8000}"
echo "APP_ENV: ${APP_ENV:-production}"

# Create storage directories if missing
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         bootstrap/cache

# Storage link
echo "--- Setting up storage link ---"
php artisan storage:link --force 2>&1 || echo "Storage link already exists or failed"

# Run migrations (non-fatal - app still starts if this fails)
echo "--- Running migrations ---"
php artisan migrate --force --no-interaction 2>&1 && echo "Migrations OK" || echo "WARNING: Migrations failed (will retry on next restart)"

# Start PHP built-in server
echo "--- Starting PHP server on port ${PORT:-8000} ---"
exec php -S 0.0.0.0:${PORT:-8000} -t public public/router.php
