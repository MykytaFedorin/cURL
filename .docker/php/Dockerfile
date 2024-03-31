FROM php:8.3.4-fpm
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/* \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer require vlucas/phpdotenv
