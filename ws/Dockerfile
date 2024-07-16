FROM php:8.1-cli

# dependencies and postgres
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev 

# Set the working directory
WORKDIR /app

# Copy the composer files
COPY composer.json composer.lock ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Allow composer to run as SU
# https://github.com/composer/composer/issues/11073
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application files
COPY . .

EXPOSE 8000

CMD ["php", "websockets_server.php"]