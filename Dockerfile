FROM php:8.4-cli

# System deps
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP deps first (cache layer)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts

# Copy rest of app
COPY . .

# Run post-install scripts now that artisan exists
RUN composer run-script post-autoload-dump --no-interaction

# Build frontend + cache
RUN npm install --ignore-scripts \
    && npm run build \
    && mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache \
    && php artisan config:cache 2>/dev/null; php artisan route:cache 2>/dev/null; php artisan view:cache 2>/dev/null; true

EXPOSE 8000

CMD ["sh", "-c", "php artisan migrate --force --no-interaction 2>/dev/null; php artisan serve --host=0.0.0.0 --port=$PORT"]
