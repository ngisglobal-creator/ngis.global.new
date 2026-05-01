# Build JS dependencies and assets
FROM node:22-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
COPY vite.config.js ./
COPY tailwind.config.js ./
COPY postcss.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm install && npm run build

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
ENV APP_DEBUG=false

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Copy built assets from node-builder
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction


# Clear caches
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Create Caddyfile
RUN echo $':80 {\n\
    root * /app/public\n\
    php_server\n\
    file_server\n\
    encode zstd gzip\n\
    header {\n\
        # Enable HTTP Strict Transport Security (HSTS)\n\
        Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"\n\
    }\n\
    handle_errors {\n\
        @404 { expression {err.status_code} == 404 }\n\
        rewrite @404 /index.php\n\
    }\n\
}' > /app/Caddyfile

# Expose port 80
EXPOSE 80

# Entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["frankenphp", "run", "--config", "/app/Caddyfile"]
