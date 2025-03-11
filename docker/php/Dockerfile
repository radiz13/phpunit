FROM php:8.3-fpm

# Fix permissions issue
USER root

# Installation des dépendances avec correction des permissions
RUN mkdir -p /var/lib/apt/lists/partial && \
    chmod 755 /var/lib/apt/lists/partial && \
    apt-get update -y && \
    apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Le reste du Dockerfile reste inchangé
RUN docker-php-ext-configure intl
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    intl

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration de PHP
COPY docker/php/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

WORKDIR /var/www/symfony

CMD ["php-fpm"]