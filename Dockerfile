FROM composer:2 AS dependencies

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-req=ext-intl \
    --ignore-platform-req=ext-mbstring


FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        mysqli \
        gd \
        intl \
        mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV PORT=10000
ENV CI_ENVIRONMENT=production

RUN sed -ri \
    -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf \
    && sed -ri \
    -e 's!AllowOverride None!AllowOverride All!g' \
    /etc/apache2/apache2.conf \
    && sed -ri \
    's!Listen 80!Listen 10000!g' \
    /etc/apache2/ports.conf \
    && sed -ri \
    's!<VirtualHost \*:80>!<VirtualHost *:10000>!g' \
    /etc/apache2/sites-available/000-default.conf

COPY --from=dependencies /app/vendor /var/www/html/vendor
COPY . /var/www/html

RUN mkdir -p \
        /var/www/html/writable \
        /var/www/html/public/uploads/avatars \
    && chown -R www-data:www-data \
        /var/www/html/writable \
        /var/www/html/public/uploads

EXPOSE 10000