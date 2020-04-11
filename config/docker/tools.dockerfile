FROM php:7.3-cli

WORKDIR /var/www

RUN docker-php-ext-install pdo pdo_mysql pcntl
RUN pecl install redis \
    && docker-php-ext-enable redis