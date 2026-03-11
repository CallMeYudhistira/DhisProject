FROM php:8.2-alpine

WORKDIR /var/www

# Install dependency + extensions
RUN apk add --no-cache \
    git \
    unzip \
    zip \
    $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo_mysql

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .
# Copy .env explicitly if it exists
COPY .env* ./

RUN composer install --no-dev --optimize-autoloader

# Create entrypoint script with TCP wait logic and storage link
RUN echo -e '#!/bin/sh\n\
echo "Creating storage symlink..."\n\
rm -rf public/storage && ln -s /var/www/storage/app/public /var/www/public/storage\n\
\n\
echo "Ensuring storage directory exists and has correct permissions..."\n\
mkdir -p storage/app/public/projects\n\
chmod -R 777 storage bootstrap/cache\n\
\n\
echo "Running migrations..."\n\
php artisan migrate --force\n\
\n\
echo "Starting server..."\n\
php -S 0.0.0.0:8000 -t public' > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8000

CMD ["/usr/local/bin/docker-entrypoint.sh"]
