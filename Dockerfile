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

RUN composer install --no-dev --optimize-autoloader

# Create entrypoint script with TCP wait logic
RUN echo -e '#!/bin/sh\n\
echo "Waiting for mysql to be ready at $DB_HOST:$DB_PORT..."\n\
while ! nc -z "$DB_HOST" "$DB_PORT"; do\n\
    sleep 1\n\
done\n\
\n\
echo "Running migrations..."\n\
php artisan migrate --force\n\
\n\
echo "Seeding database..."\n\
php artisan db:seed --force\n\
\n\
echo "Starting server..."\n\
php -S 0.0.0.0:8000 -t public' > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8000

CMD ["/usr/local/bin/docker-entrypoint.sh"]
