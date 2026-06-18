FROM php:8.4-fpm

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

# Install Node.js 22
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# ── npm install (cached unless package.json changes) ─────────────────────────
COPY package.json package-lock.json ./
RUN npm ci

# ── Copy all project files ────────────────────────────────────────────────────
COPY . .

# ── Composer install (needs project files for post-install scripts) ───────────
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# ── Build Vite assets ─────────────────────────────────────────────────────────
RUN npm run build && rm -rf node_modules

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
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default \
    && rm -f /etc/nginx/sites-enabled/default 2>/dev/null || true \
    && ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Configure Supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/vision-medical.conf

# Startup script
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/bin/bash", "/start.sh"]
