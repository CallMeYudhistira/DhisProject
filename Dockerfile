FROM php:8.2-alpine

WORKDIR /var/www

# Install dependency + redis extension
RUN apk add --no-cache \
    git \
    unzip \
    zip \
    $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

CMD php -S 0.0.0.0:8000 -t public
