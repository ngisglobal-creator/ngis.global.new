#!/bin/bash
set -e

# Force environment variables for stability (override any Railway Variables)
export SESSION_DRIVER=file
export CACHE_STORE=file
export APP_DEBUG=true

# Clear any existing config/route cache to avoid stale settings
echo "Clearing old cache files..."
rm -f /app/bootstrap/cache/config.php
rm -f /app/bootstrap/cache/routes-v7.php
rm -f /app/bootstrap/cache/services.php
rm -f /app/bootstrap/cache/packages.php

# Ensure SQLite database file exists
echo "Ensuring SQLite database exists..."
mkdir -p /app/database
if [ ! -f /app/database/database.sqlite ]; then
    echo "Creating new SQLite database file..."
    touch /app/database/database.sqlite
fi
chmod 666 /app/database/database.sqlite
echo "Database file status:"
ls -la /app/database/database.sqlite

# Ensure storage directories are writable
chmod -R 777 /app/storage /app/bootstrap/cache /app/database

# ALWAYS run migrations on startup to ensure tables exist
echo "Running migrations..."
php artisan migrate --force 2>&1 || echo "WARNING: Migrations may have failed!"

echo "Migration status:"
php artisan migrate:status 2>&1 || echo "Could not check migration status."

# Cache configuration and routes for production performance
echo "Caching configuration..."
php artisan config:cache 2>&1 || echo "Config cache failed"

echo "Caching routes..."
php artisan route:cache 2>&1 || echo "Route cache failed"

echo "Caching views..."
php artisan view:cache 2>&1 || echo "View cache failed"

echo "Application started successfully!"

# Execute the main process
exec "$@"
