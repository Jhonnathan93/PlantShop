FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends git libonig-dev libpng-dev libpq-dev libzip-dev unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd mbstring pdo_mysql pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader

COPY . .
COPY docker/entrypoint.sh /usr/local/bin/plantshop-entrypoint

RUN composer dump-autoload --no-dev --optimize

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && a2enmod rewrite \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod +x /usr/local/bin/plantshop-entrypoint

ENTRYPOINT ["plantshop-entrypoint"]
CMD ["apache2-foreground"]
