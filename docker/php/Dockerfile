FROM php:8.3-fpm
ENTRYPOINT ["php-fpm"]

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    libzip-dev

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_pgsql xdebug zip

RUN apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY ./docker/php/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

COPY . /app

WORKDIR /app

RUN composer install --no-interaction --prefer-dist --optimize-autoloader