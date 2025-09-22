# --------------------------
# Image PHP 8.2 FPM Alpine
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
    pkgconfig \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# --------------------------
# Copier config PHP personnalisée
# --------------------------
COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# --------------------------
# Installer Composer
# --------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --------------------------
# Copier le projet Symfony
# --------------------------
WORKDIR /var/www/html
COPY . /var/www/html

# --------------------------
# Installer les dépendances Symfony
# --------------------------
RUN composer install --no-interaction --optimize-autoloader --no-dev

# --------------------------
# Fixer les permissions pour Symfony
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

# --------------------------
# Commande par défaut
# --------------------------
CMD ["php-fpm"]
