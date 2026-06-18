# ══════════════════════════════════════════════════════════════════════════════
# Stage 1: Build frontend assets (Node.js 18)
# ══════════════════════════════════════════════════════════════════════════════
FROM node:18 AS build

WORKDIR /app

# Cache npm dependencies separately
COPY package.json package-lock.json ./
RUN npm install

# Copy all source files and build Vite assets
COPY . .
RUN npm run build

# ══════════════════════════════════════════════════════════════════════════════
# Stage 2: PHP runtime (8.2-fpm + Nginx + Supervisor)
# ══════════════════════════════════════════════════════════════════════════════
FROM php:8.2-fpm

# Install system dependencies + Nginx + Supervisor
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
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

WORKDIR /app

# ── Copy all project files ────────────────────────────────────────────────────
COPY . .

# ── Copy built frontend assets from Stage 1 ──────────────────────────────────
COPY --from=build /app/public/build /app/public/build

# ── Composer install (production, no dev deps) ────────────────────────────────
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Set up directories and permissions
RUN mkdir -p storage/framework/cache/data \
             storage/framework/sessions \
             storage/framework/views \
             storage/logs \
             bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /app

# Configure Nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default
RUN rm -f /etc/nginx/sites-enabled/default \
    && ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Configure Supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/vision-medical.conf

# Startup script
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/bin/bash", "/start.sh"]
