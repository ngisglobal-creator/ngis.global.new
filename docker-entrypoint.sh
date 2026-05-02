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
echo "Caching configuration..."
php artisan config:cache || echo "Config cache failed"
echo "Caching routes..."
php artisan route:cache || echo "Route cache failed"
echo "Caching views..."
php artisan view:cache || echo "View cache failed"

# Execute the CMD
exec "$@"
