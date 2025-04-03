FROM php:8.3-fpm

ADD ./docker/php/www.conf /usr/local/etc/php-fpm.d/

#RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel
RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel laravel

RUN mkdir -p /var/www/html

RUN chown laravel:laravel /var/www/html

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y --force-yes --no-install-recommends \
        libmemcached-dev \
        libzip-dev \
        libz-dev \
        libzip-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        openssh-server \
        libmagickwand-dev \
        git \
        cron \
        curl \
        nano \
        libxml2-dev \
        libreadline-dev \
        libgmp-dev \
        libonig-dev \
        mariadb-client \
        unzip

# Pecl channel-update
RUN pecl channel-update pecl.php.net

# Install soap extention
RUN docker-php-ext-install soap

# Install for image manipulation
RUN docker-php-ext-install exif

# Install the PHP pcntl extention
RUN docker-php-ext-install pcntl

# Install the PHP zip extention
RUN docker-php-ext-install zip

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql

# Install the PHP pdo_pgsql extention
RUN docker-php-ext-install pdo_pgsql

# Install the PHP bcmath extension
RUN docker-php-ext-install bcmath

# Install the PHP intl extention
RUN docker-php-ext-install intl

# Install the PHP gmp extention
RUN docker-php-ext-install gmp

# Install the php redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install the php memcached extension
# RUN pecl install memcached && docker-php-ext-enable memcached

# Install the PHP sockets extention
# RUN docker-php-ext-install sockets && docker-php-ext-enable sockets

# Install the PHP igbinary extention
#RUN docker-php-ext-install igbinary

#####################################
# GD:
#####################################

# Install the PHP gd library
RUN docker-php-ext-install gd && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

#####################################
# Imagick:
#####################################

RUN pecl install imagick && docker-php-ext-enable imagick

#####################################
# xDebug:
#####################################

# Install the xdebug extension
RUN pecl install xdebug

#####################################
# Swoole:
#####################################

RUN pecl install swoole && docker-php-ext-enable swoole


RUN echo "* * * * * laravel /usr/local/bin/php /var/www/html/artisan schedule:run >> /dev/null 2>&1"  >> /etc/cron.d/laravel-scheduler
RUN chmod 0644 /etc/cron.d/laravel-scheduler

COPY ./docker/php/php.ini "$PHP_INI_DIR/php.ini"
#COPY ../../supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN rm -rf /tmp/pear
