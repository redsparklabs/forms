# syntax=docker/dockerfile:1
FROM php:8.2-fpm-alpine

# Install system deps
RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    oniguruma-dev \
    libzip-dev \
    bash \
    shadow \
    icu-dev

# Install PHP extensions
RUN docker-php-ext-configure intl \
 && docker-php-ext-install pdo_mysql bcmath mbstring zip intl

# Set working directory
WORKDIR /var/www/html

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure www-data user to match common host UID/GID (optional)
RUN usermod -u 1000 www-data || true && groupmod -g 1000 www-data || true

# Expose FPM port
EXPOSE 9000

CMD ["php-fpm"]
