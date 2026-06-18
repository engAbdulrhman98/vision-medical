#!/bin/bash

echo "=== Vision Medical - Starting up ==="
echo "PORT: ${PORT:-8000}"
echo "APP_ENV: ${APP_ENV:-production}"
echo "DB_HOST: ${DB_HOST:-NOT_SET}"
echo "PWD: $(pwd)"

# --- Check build assets exist ---
echo ""
echo "--- Checking public/build/ ---"
if [ -d "public/build" ]; then
    echo "✓ public/build/ exists"
    ls -la public/build/
    echo ""
    echo "Assets:"
    ls -la public/build/assets/ 2>/dev/null || echo "✗ public/build/assets/ missing!"
else
    echo "✗ public/build/ DOES NOT EXIST!"
fi
echo ""

# Create storage directories if missing
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         bootstrap/cache

# Storage link
echo "--- Setting up storage link ---"
php artisan storage:link --force 2>&1 || echo "Storage link skipped"

# Run migrations (non-fatal)
echo "--- Running migrations ---"
php artisan migrate --force --no-interaction 2>&1 && echo "✓ Migrations OK" || echo "⚠ Migrations failed (app will still start)"

# Start PHP server
echo ""
echo "--- Starting PHP server on port ${PORT:-8000} ---"
exec php -S 0.0.0.0:${PORT:-8000} -t public public/router.php
