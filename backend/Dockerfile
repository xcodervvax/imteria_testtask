FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl libpq-dev zip unzip

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/backend
