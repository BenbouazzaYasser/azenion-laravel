FROM php:8.4-apache

# System deps
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    nodejs npm sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pdo_sqlite mbstring exif pcntl bcmath gd zip \
    && (a2dismod mpm_event mpm_worker mpm_prefork 2>/dev/null || true) \
    && a2enmod mpm_prefork \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts

# Copy rest
COPY . .

# Finish composer post-install steps now that artisan exists, then build frontend
RUN composer run-script post-autoload-dump \
    && npm install \
    && npm run build \
    && php artisan config:clear

# Apache config
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && mkdir -p /var/www/html/database && touch /var/www/html/database/database.sqlite && chown www-data:www-data /var/www/html/database/database.sqlite

EXPOSE 80

# Start script: migrate + cache + apache
CMD php artisan migrate --force --no-interaction || true; php artisan config:cache; php artisan route:cache; php artisan view:cache; apache2-foreground

