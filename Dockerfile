FROM php:7.3.0-apache

RUN curl -s$ https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get update && apt-get install -y git libzip-dev unzip \
    && docker-php-ext-install zip \
    && a2enmod rewrite headers

RUN docker-php-ext-install pdo_mysql

COPY . /var/www/html

WORKDIR /var/www/html/app

RUN composer install
RUN composer require doctrine/annotations
