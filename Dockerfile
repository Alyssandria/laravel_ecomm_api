FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    bash \
    curl \
    libpng-dev \
    oniguruma-dev \
    postgresql-dev \
    zip \
    unzip \
    supervisor \
    git

# PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    bcmath \
    gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY . .

# Fix "dubious ownership" error
RUN git config --global --add safe.directory /var/www/html

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy Nginx config
COPY deploy/nginx.conf /etc/nginx/nginx.conf

# Copy entrypoint script
COPY deploy/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
