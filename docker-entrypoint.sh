#!/bin/bash
set -e

# Ensure SQLite database exists if needed
if [ ! -f database/database.sqlite ]; then
    echo "Creating SQLite database file..."
    mkdir -p database
    touch database/database.sqlite
    chmod 666 database/database.sqlite
fi

# Ensure storage and bootstrap/cache are writable at runtime
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

# Run migrations if enabled
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Cache configuration and routes for production
echo "Caching configuration..."
php artisan config:cache || echo "Config cache failed"
echo "Caching routes..."
php artisan route:cache || echo "Route cache failed"
echo "Caching views..."
php artisan view:cache || echo "View cache failed"

# Execute the CMD
exec "$@"
