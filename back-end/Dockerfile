FROM php:8.2-fpm-alpine

# Dépendances système utiles
RUN apk add --no-cache git unzip icu-dev libzip-dev bash

# Extensions PHP nécessaires pour Symfony
RUN docker-php-ext-configure intl \
 && docker-php-ext-install intl pdo pdo_mysql zip opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
USER www-data

CMD ["php-fpm"]
