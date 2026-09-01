FROM php:8.2-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev \
    libsqlite3-dev zip sqlite3 && \
    rm -rf /var/lib/apt/lists/*

# PHP extensions — pdo_sqlite instead of pdo_mysql
RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

WORKDIR /var/www

COPY . .

# PHP dependencies (no dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Frontend assets
RUN npm ci && npm run build

# Storage permissions
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# SQLite database directory outside webroot
RUN mkdir -p /data && touch /data/database.sqlite && \
    chown -R www-data:www-data /data

# Expect .env to be injected as environment variables at runtime
# Run migrations + cache at start via entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
