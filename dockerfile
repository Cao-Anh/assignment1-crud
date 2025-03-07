# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copy the custom Xdebug configuration
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set correct permissions for uploaded files
RUN chown -R www-data:www-data /var/www/html

# Copy project files into container
COPY . /var/www/html/

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
