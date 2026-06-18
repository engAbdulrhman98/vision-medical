#!/bin/bash

echo "=== Vision Medical - Starting (Nginx + PHP-FPM) ==="
echo "PORT: ${PORT:-8080}"
echo "APP_ENV: ${APP_ENV:-production}"

# Ensure correct permissions at runtime
chown -R www-data:www-data /app/storage /app/bootstrap/cache 2>/dev/null || true

# Storage link
echo "--- Setting up storage link ---"
php artisan storage:link --force 2>&1 || echo "Storage link skipped"

# Run migrations
echo "--- Running migrations ---"
php artisan migrate --force --no-interaction 2>&1 && echo "✓ Migrations OK" || echo "⚠ Migrations failed"

# Check build assets
echo "--- Build assets check ---"
ls -lh /app/public/build/assets/*.css 2>/dev/null && echo "✓ CSS assets exist" || echo "⚠ No CSS assets!"

echo ""
echo "--- Starting Nginx + PHP-FPM via Supervisor ---"
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/vision-medical.conf
