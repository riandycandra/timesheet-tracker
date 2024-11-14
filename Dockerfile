# Use the PHP 8.2 Alpine FPM image
FROM php:8.2-fpm-alpine

# Install dependencies
RUN apk --no-cache add \
    git \
    zip \
    unzip \
    nginx \
    libzip-dev \
    postgresql-dev \
    supervisor \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql zip intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install -vvv

# Ensure storage and bootstrap/cache are writable
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Copy Supervisor configurations
COPY docker/supervisord.conf /etc/supervisor.d/supervisord.conf
COPY docker/laravel-worker.conf /etc/supervisor.d/laravel-worker.conf

# Expose port 80 for Nginx
EXPOSE 80

# Start Supervisor and php-fpm
CMD ["supervisord", "-c", "/etc/supervisor.d/supervisord.conf"]
