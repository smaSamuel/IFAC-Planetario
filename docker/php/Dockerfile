# PHP 8.2 com Apache
FROM php:8.2-apache

# Extensões necessárias
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        zip \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configuração do Apache: DocumentRoot aponta para /public e AllowOverride habilitado
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf \
    && echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' \
       >> /etc/apache2/sites-available/000-default.conf

COPY --from=composer /usr/bin/composer /usr/bin/composer
 
WORKDIR /var/www/html
 
EXPOSE 80
 

