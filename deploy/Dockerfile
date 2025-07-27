FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev unzip git libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql intl

# Enable mod_rewrite
RUN a2enmod rewrite

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache config
RUN sed -ri "s|DocumentRoot /var/www/html|DocumentRoot ${APACHE_DOCUMENT_ROOT}|" /etc/apache2/sites-available/000-default.conf \
 && echo "<Directory ${APACHE_DOCUMENT_ROOT}>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/ci4-access.conf \
 && a2enconf ci4-access

# Set working dir
WORKDIR /var/www/html

# Copy app files
COPY ../ /var/www/html/

# Permissions
RUN chmod -R 755 /var/www/html \
    && chown -R www-data:www-data /var/www/html/writable

EXPOSE 80
