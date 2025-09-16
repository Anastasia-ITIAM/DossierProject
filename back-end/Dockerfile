FROM php:8.2-fpm-alpine

# --------------------------
# Dépendances système utiles
# --------------------------
RUN apk add --no-cache \
    git \
    unzip \
    icu-dev \
    libzip-dev \
    bash \
    autoconf \
    g++ \
    make \
    openssl-dev \
    libc-dev \
    oniguruma-dev \
    curl \
    pkgconfig \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

# --------------------------
# Installer MongoDB 2.x via PECL
# --------------------------
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# --------------------------
# Copier la config uploads.ini
# --------------------------
COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# --------------------------
# Installer Composer depuis l'image officielle
# --------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --------------------------
# Définir le répertoire de travail
# --------------------------
WORKDIR /var/www/html
USER www-data

# --------------------------
# Commande par défaut
# --------------------------
CMD ["php-fpm"]
