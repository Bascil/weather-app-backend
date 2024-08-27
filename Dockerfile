# Stage 1: Dependencies
FROM php:8.3-alpine AS dependencies

# Install necessary tools and extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pcntl sockets

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy only the files needed for composer install
COPY composer.json composer.lock /var/www/
WORKDIR /var/www

# Install dependencies
RUN composer install --no-dev --no-scripts --no-autoloader

# Stage 2: Application
FROM php:8.3-alpine AS application

# Copy installed dependencies from the previous stage
COPY --from=dependencies /var/www/vendor /var/www/vendor

# Install necessary tools and extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pcntl sockets

# Install jq and frankenphp
RUN apk add --no-cache jq && \
    wget -O/usr/local/bin/frankenphp $(wget -O- https://api.github.com/repos/dunglas/frankenphp/releases/latest | jq '.assets[] | select(.name=="frankenphp-linux-x86_64") | .browser_download_url' -r) && \
    chmod +x /usr/local/bin/frankenphp

# Copy application files
COPY . /var/www
COPY .env /var/www/.env
WORKDIR /var/www

# Finish Composer setup
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer dump-autoload --optimize

# Set the entrypoint
ENTRYPOINT ["php", "artisan", "octane:start", "--server=frankenphp", "--port=9804", "--workers=16", "--host=0.0.0.0"]