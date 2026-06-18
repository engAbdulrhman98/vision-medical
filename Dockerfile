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

# ── Layer 1: npm deps (cached unless package.json changes) ───────────────────
COPY package.json package-lock.json ./
RUN npm ci

# ── Layer 2: ALL source files ─────────────────────────────────────────────────
COPY . .

# ── Layer 3: PHP deps + post-install scripts (needs project files) ────────────
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# ── Layer 4: Build Vite assets ────────────────────────────────────────────────
RUN npm run build && rm -rf node_modules

# Set permissions
RUN mkdir -p storage/framework/cache/data \
             storage/framework/sessions \
             storage/framework/views \
             storage/logs \
             bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy and configure startup script
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8000

CMD ["/bin/bash", "/start.sh"]
