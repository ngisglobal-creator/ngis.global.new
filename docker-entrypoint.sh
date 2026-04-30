#!/bin/bash
set -e

# Wait for database if needed (optional)
# sleep 5

# Run migrations if enabled
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Cache configuration and routes for production
echo "Caching configuration and routes..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Execute the CMD
exec "$@"
