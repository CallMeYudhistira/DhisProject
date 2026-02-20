FROM php:8.2-alpine

WORKDIR /var/www

# Install dependency kecil saja
RUN apk add --no-cache \
    git \
    unzip \
    zip

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

CMD php -S 0.0.0.0:8000 -t public
