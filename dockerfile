# 1. Gunakan PHP 8.2
FROM php:8.2-apache

# 2. Install library sistem + CURL (untuk download Node.js)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    curl \
    gnupg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql zip intl

# 3. --- TAMBAHAN BARU: Install Node.js v18 & NPM ---
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# 4. Aktifkan mod_rewrite
RUN a2enmod rewrite

# 5. Set folder kerja
WORKDIR /var/www/html

# 6. Copy semua file project
COPY . .

# 7. Install Composer (PHP Dependencies)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 8. --- TAMBAHAN BARU: Build Aset Frontend (CSS/JS) ---
RUN npm install
RUN npm run build

# 9. Set Permission Folder
RUN chown -R www-data:www-data storage bootstrap/cache

# 10. Konfigurasi Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Fix Apache Routing (Login 404)
RUN echo "<Directory /var/www/html/public>" >> /etc/apache2/apache2.conf && \
    echo "    AllowOverride All" >> /etc/apache2/apache2.conf && \
    echo "</Directory>" >> /etc/apache2/apache2.conf

# 11. Expose
EXPOSE 80