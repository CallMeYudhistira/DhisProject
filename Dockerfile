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

# Create entrypoint script with robust wait-for-db logic
RUN echo '#!/bin/sh' > /usr/local/bin/docker-entrypoint.sh && \
    echo '' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'echo "=== DhisProject Entrypoint ==="' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '# --- Storage Setup ---' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'echo "Creating storage symlink..."' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'rm -rf public/storage && ln -s /var/www/storage/app/public /var/www/public/storage' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'mkdir -p storage/app/public/projects' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'chmod -R 777 storage bootstrap/cache' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '# --- Wait for MySQL ---' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'echo "Waiting for MySQL to be ready..."' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'MAX_RETRIES=30' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'RETRY=0' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'until nc -z -w2 db 3306 2>/dev/null; do' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  RETRY=$((RETRY + 1))' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  if [ "$RETRY" -ge "$MAX_RETRIES" ]; then' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '    echo "ERROR: MySQL not reachable after $MAX_RETRIES attempts. Starting server anyway..."' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '    break' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  fi' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  echo "  MySQL not ready yet (attempt $RETRY/$MAX_RETRIES)... waiting 2s"' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  sleep 2' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'done' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'echo "MySQL is reachable! Waiting 3s extra for full init..."' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'sleep 3' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '# --- Wait for Redis ---' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'echo "Waiting for Redis..."' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'RETRY=0' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'until nc -z -w2 redis 6379 2>/dev/null; do' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  RETRY=$((RETRY + 1))' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  if [ "$RETRY" -ge 10 ]; then' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '    echo "WARNING: Redis not reachable. Continuing anyway..."' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '    break' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  fi' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  echo "  Redis not ready (attempt $RETRY/10)... waiting 1s"' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '  sleep 1' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'done' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '# --- Run Migrations ---' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'echo "Running migrations..."' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'php artisan migrate --force || echo "Migration failed, but server will still start."' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '' >> /usr/local/bin/docker-entrypoint.sh && \
    echo '# --- Start Server ---' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'echo "Starting server on port 8000..."' >> /usr/local/bin/docker-entrypoint.sh && \
    echo 'exec php -S 0.0.0.0:8000 -t public' >> /usr/local/bin/docker-entrypoint.sh && \
    chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8000

CMD ["/usr/local/bin/docker-entrypoint.sh"]
