FROM php:7.4-cli-alpine

# alpine components
RUN set -xe && apk update && apk add --no-cache \
    libzip \
    bash \
    curl \
    libmcrypt-dev \
    libxml2-dev \
    libzip-dev \
    postgresql-dev \
    pcre-dev \
    git \
    autoconf \
    g++ \
    make


# php pecl components
RUN docker-php-ext-install pdo_pgsql zip pcntl sockets soap \
    && docker-php-source extract \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && echo 'date.timezone=Europe/London' >> /usr/local/etc/php/conf.d/php-date.ini


# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && mkdir -p /.composer \
    && chmod -Rf 777 /.composer


WORKDIR /var/app
