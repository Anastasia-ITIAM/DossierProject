# --------------------------
# PHP 8.2 FPM Alpine Image
# --------------------------
FROM php:8.2-fpm-alpine

# --------------------------
# Dépendances système
# --------------------------
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    icu-dev \
    libzip-dev \
    autoconf \
    g++ \
    make \
    openssl-dev \
    libc-dev \
    oniguruma-dev \
    curl \
    pkgconfig

# --------------------------
# Extensions PHP
# --------------------------
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# --------------------------
# Configuration PHP
# --------------------------
COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# --------------------------
# Installer Composer
# --------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set workdir
WORKDIR /var/www/html

# Copy all files from the build context (./back-end/app)
COPY . /var/www/html


# --------------------------
# Installer les dépendances Symfony
# --------------------------
RUN composer install --no-interaction --optimize-autoloader

# --------------------------
# Permissions
# --------------------------
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/public

# --------------------------
# Utilisateur non-root
# --------------------------
USER www-data

# --------------------------
# Exposer le port PHP-FPM
# --------------------------
EXPOSE 9000

CMD ["php-fpm"]
