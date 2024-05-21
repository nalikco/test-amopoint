FROM php:8.3.7-cli

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    libsqlite3-dev \
    unzip \
    && docker-php-ext-install curl pdo pdo_sqlite

COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-scripts --no-autoloader

COPY . .

RUN composer dump-autoload --optimize
