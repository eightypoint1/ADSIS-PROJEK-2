FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN addgroup -g 1000 appgroup && \
    adduser -u 1000 -G appgroup -s /bin/bash -D appuser

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .
RUN chown -R appuser:appgroup /var/www/html && \
    chmod -R 755 storage bootstrap/cache

USER appuser
EXPOSE 9000
CMD ["php-fpm"]
