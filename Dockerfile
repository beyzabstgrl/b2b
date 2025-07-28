# ──────────────────────────────────────────────────
# Dockerfile
# ──────────────────────────────────────────────────

# 1. Base image
FROM php:8.2-fpm

# 2. System dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    unzip

# 3. PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# 4. Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# 5. Workdir
WORKDIR /var/www

# 6. Application copy
COPY . /var/www

# Allow composer run as root and disable interaction
ENV COMPOSER_ALLOW_SUPERUSER=1

# 7. Composer install
RUN composer install --optimize-autoloader --no-dev --no-interaction --prefer-dist

# 8. Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# 9. Expose & start
EXPOSE 9000
CMD ["php-fpm"]
