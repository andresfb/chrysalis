FROM php:7.3-cli-alpine

WORKDIR /var/www

RUN docker-php-ext-install pdo pdo_mysql pcntl
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis