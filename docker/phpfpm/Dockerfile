FROM php:7.1-fpm

RUN docker-php-ext-install pdo pdo_mysql opcache

RUN apt-get update && apt-get install -y \
    build-essential \
    libz-dev \
    git \
&& pecl install apcu \
&& docker-php-ext-enable apcu

# install blackfire.
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
&& curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
&& tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
&& mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
&& printf "extension=blackfire.so\nblackfire.agent_socket=tcp://cveehub_blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini