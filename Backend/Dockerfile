FROM php:8.2-apache

# Dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    curl

# Extensions PHP (IMPORTANT)
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd

# Apache rewrite
RUN a2enmod rewrite

# Dossier de travail
WORKDIR /var/www/html

# Copier le projet
COPY . .

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installer Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissions Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Apache → dossier public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]


