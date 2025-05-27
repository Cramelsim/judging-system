FROM php:8.2-apache

# Set Apache to match host user permissions
ARG APACHE_UID=1000
ARG APACHE_GID=1000
RUN usermod -u $APACHE_UID www-data && \
    groupmod -g $APACHE_GID www-data

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli zip gd mbstring

# Enable Apache modules
RUN a2enmod rewrite headers

# Configure Apache - Modified to use /var/www/html instead of /public
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -ri -e 's!/var/www/html!/var/www/html!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!/var/www/html!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    echo "<Directory /var/www/html>\n\tAllowOverride All\n\tRequire all granted\n</Directory>" >> /etc/apache2/apache2.conf && \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/Options Indexes FollowSymLinks/Options FollowSymLinks/' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Health check
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost/ || exit 1

EXPOSE 80