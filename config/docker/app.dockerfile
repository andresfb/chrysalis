FROM php:7.3-fpm

WORKDIR /var/www

RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install redis \
    && docker-php-ext-enable redis