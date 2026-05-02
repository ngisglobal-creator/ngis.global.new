# Build JS dependencies and assets
FROM node:22-alpine AS node-builder
RUN apk add --no-cache libc6-compat
WORKDIR /app
COPY package*.json ./
RUN npm install --frozen-lockfile || npm install
COPY . .
RUN rm -rf public/build && npm run build

FROM dunglas/frankenphp:1.2-php8.3-alpine

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    bash

# Install PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    opcache

# Set environment variables
ENV AUTOCONF_MODERN=1
ENV FRANKENPHP_CONFIG="import /app/Caddyfile"
ENV APP_ENV=production
ENV APP_DEBUG=true
ENV LOG_CHANNEL=stderr
ENV RUN_MIGRATIONS=true
ENV SESSION_DRIVER=file
ENV CACHE_STORE=file

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Copy built assets from node-builder
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN mkdir -p storage/logs bootstrap/cache database
RUN touch database/database.sqlite
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache /app/database
RUN chmod -R 775 /app/storage /app/bootstrap/cache /app/database
RUN chmod 666 /app/database/database.sqlite

# Copy Caddyfile
COPY Caddyfile /app/Caddyfile

# Expose port 80
EXPOSE 80

# Entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["frankenphp", "run", "--config", "/app/Caddyfile"]

