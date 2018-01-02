FROM php:7.1-fpm

RUN docker-php-ext-install pdo pdo_mysql opcache

RUN apt-get update && apt-get install -y \
    build-essential \
    libz-dev \
    git \
&& pecl install apcu \
&& docker-php-ext-enable apcu

# install xdebug for code coverage and stuff.
RUN yes | pecl install xdebug \
&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini