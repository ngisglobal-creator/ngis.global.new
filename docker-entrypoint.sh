#!/bin/bash
set -e

# Force environment variables for stability
export SESSION_DRIVER=file
export CACHE_STORE=file
export APP_DEBUG=true

# Clear any existing config cache to avoid stale settings
if [ -f /app/bootstrap/cache/config.php ]; then
    rm /app/bootstrap/cache/config.php
fi

# Ensure SQLite database exists if needed (using absolute paths)
echo "Current working directory: $(pwd)"
if [ ! -f /app/database/database.sqlite ]; then
    echo "Creating SQLite database file at /app/database/database.sqlite..."
    mkdir -p /app/database
    touch /app/database/database.sqlite
fi
chmod 666 /app/database/database.sqlite

echo "Checking database file status:"
ls -la /app/database/database.sqlite || echo "Database file NOT found at /app/database/database.sqlite!"

# Ensure storage and bootstrap/cache are writable at runtime
chmod -R 775 /app/storage /app/bootstrap/cache /app/database
chown -R www-data:www-data /app/storage /app/bootstrap/cache /app/database || true

# Run migrations if enabled
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running migrations for SQLite..."
    php artisan migrate --force --database=sqlite || echo "Migrations failed!"
fi

echo "Checking database tables:"
php artisan db:show --database=sqlite || echo "Could not show database tables."

# Cache configuration and routes for production
echo "Caching configuration..."
php artisan config:cache || echo "Config cache failed"
echo "Caching routes..."
php artisan route:cache || echo "Route cache failed"
echo "Caching views..."
php artisan view:cache || echo "View cache failed"

# Execute the CMD
exec "$@"
