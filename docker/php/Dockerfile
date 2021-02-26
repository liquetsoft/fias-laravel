FROM php:8-cli-alpine


RUN set -xe && apk update && apk add --no-cache \
    libzip \
    bash \
    curl \
    libmcrypt-dev \
    libxml2-dev \
    libzip-dev \
    pcre-dev \
    git \
    autoconf \
    g++ \
    make


RUN docker-php-ext-install zip soap \
    && docker-php-source extract \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && echo 'date.timezone=Europe/London' >> /usr/local/etc/php/conf.d/php-date.ini \
    && echo 'xdebug.mode=coverage' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  --version=2.0.11 \
    && mkdir -p /.composer && chmod -Rf 777 /.composer


WORKDIR /var/app
