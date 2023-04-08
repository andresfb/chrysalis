ARG PHP_VERSION=${PHP_VERSION}
FROM php:${PHP_VERSION}-alpine

RUN echo -n "Add a non-root user\n "
ARG DOCKER_USER_UID=1000
ENV DOCKER_USER_UID ${DOCKER_USER_UID}
ARG DOCKER_USER_GID=1000
ENV DOCKER_USER_GID ${DOCKER_USER_GID}

RUN addgroup -g ${DOCKER_USER_GID} php-worker && \
    adduser -D -G php-worker -u ${DOCKER_USER_UID} php-worker

RUN echo -n "Install Software\n "
RUN apk --update add wget \
  curl \
  git \
  build-base \
  libmemcached-dev \
  libmcrypt-dev \
  libxml2-dev \
  pcre-dev \
  zlib-dev \
  autoconf \
  cyrus-sasl-dev \
  libgsasl-dev \
  supervisor

RUN echo -n "Install PHP extensions\n "
RUN docker-php-ext-install mysqli mbstring pdo pdo_mysql tokenizer xml pcntl
RUN pecl channel-update pecl.php.net && pecl install memcached mcrypt-1.0.1 && docker-php-ext-enable memcached

RUN echo -n "Install Redis extension\n "
ARG DOCKER_INSTALL_REDIS="off"
RUN if [ ${DOCKER_INSTALL_REDIS} != "off" ]; then \
    printf "\n" | pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis \
;fi

RUN echo -n "Install PostgreSQL drivers\n "
ARG DOCKER_INSTALL_PGSQL="off"
RUN if [ ${DOCKER_INSTALL_PGSQL} != "off" ]; then \
    apk --update add postgresql-dev \
        && docker-php-ext-install pdo_pgsql \
;fi

RUN echo -n "Install SOAP package\n "
ARG DOCKER_INSTALL_SOAP="off"
RUN if [ ${DOCKER_INSTALL_SOAP} != "off" ]; then \
    docker-php-ext-install soap \
;fi

RUN echo -n "Install BCMath package\n "
ARG DOCKER_INSTALL_BCMATH="off"
RUN if [ ${DOCKER_INSTALL_BCMATH} != "off" ]; then \
    docker-php-ext-install bcmath \
;fi

RUN echo -n "Install ZipArchive\n "
ARG DOCKER_INSTALL_ZIP_ARCHIVE="off"
RUN if [ ${DOCKER_INSTALL_ZIP_ARCHIVE} != "off" ]; then \
    apk --update add libzip-dev && \
    docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-install zip \
;fi

RUN echo -n "Install MySQL Client\n "
ARG DOCKER_INSTALL_MYSQL_CLIENT="off"
RUN if [ ${DOCKER_INSTALL_MYSQL_CLIENT} != "off" ]; then \
    apk --update add mysql-client \
;fi

RUN echo -n "Install FFMPEG\n "
ARG DOCKER_INSTALL_FFMPEG="off"
RUN if [ ${DOCKER_INSTALL_FFMPEG} != "off" ]; then \
    apk --update add ffmpeg \
;fi

RUN echo -n "Install Ghostscript\n "
ARG DOCKER_INSTALL_GHOSTSCRIPT="off"
RUN if [ $DOCKER_INSTALL_GHOSTSCRIPT != "off" ]; then \
    apk --update add ghostscript \
;fi

RUN echo -n "Install GMP package\n "
ARG DOCKER_INSTALL_GMP="off"
RUN if [ ${DOCKER_INSTALL_GMP} != "off" ]; then \
   apk add --update --no-cache gmp gmp-dev \
   && docker-php-ext-install gmp \
;fi

RUN echo -n "Install Php TAINT extension\n "
ARG DOCKER_INSTALL_TAINT="off"
RUN if [ ${DOCKER_INSTALL_TAINT} != "off" ]; then \
    if [ $(php -r "echo PHP_MAJOR_VERSION;") = "7" ]; then \
      pecl install taint; \
    fi && \
    docker-php-ext-enable taint \
;fi

RUN rm /var/cache/apk/* \
    && mkdir -p /var/www

#
#--------------------------------------------------------------------------
# Optional Supervisord Configuration
#--------------------------------------------------------------------------
#
# Modify the ./supervisor.conf file to match your App's requirements.
# Make sure you rebuild your container with every change.
#

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

#
#--------------------------------------------------------------------------
# Check PHP version
#--------------------------------------------------------------------------
#

RUN php -v | head -n 1 | grep -q "PHP ${PHP_VERSION}."

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

WORKDIR /etc/supervisor/conf.d/

