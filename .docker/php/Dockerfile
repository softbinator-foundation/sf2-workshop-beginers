# Take a look at the PHP container documentation on the Dockerhub for more detailed
# info on running the container: https://hub.docker.com/_/php/
FROM php:7.0-fpm

# Installing some extra packages
RUN apt-get update && \
    apt-get install -y \
      git \
      unzip

# Install extensions through the scripts the container provides
RUN docker-php-ext-install -j$(nproc) pdo_mysql

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
COPY ./.docker/php/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install opcache

RUN apt-get install -y libicu-dev
RUN pecl install intl
RUN docker-php-ext-install -j$(nproc) intl

# Install Composer and make it available in the PATH
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN curl -LsS https://symfony.com/installer -o /usr/bin/symfony && chmod a+x /usr/bin/symfony

# Set the WORKDIR to /var/app so all following commands run in /var/app
WORKDIR /var/app
