# Use PHP as the base image
FROM php:latest

# Set the working directory inside the container
WORKDIR /

# Copy PHP files from host to the container
COPY . /

# Install PHP extensions required by Slim and PHPMailer
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies using Composer
RUN composer install --no-dev

# Expose port 80 (assuming your PHP application runs on port 80)
EXPOSE 80

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:80", "-t", "/"]
