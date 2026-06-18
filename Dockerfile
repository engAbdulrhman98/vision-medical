FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libexif-dev \
    zip \
    unzip \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        bcmath \
        gd \
        zip \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js 22
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Install Node.js dependencies and build assets
RUN npm ci --ignore-scripts && npm run build && rm -rf node_modules

# Set permissions
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    || true

# Expose port (Railway sets $PORT)
EXPOSE 8000

# Start: run migrations then start PHP server with router
CMD sh -c "php artisan migrate --force; php artisan storage:link 2>/dev/null || true; php -S 0.0.0.0:${PORT:-8000} -t public public/router.php"
