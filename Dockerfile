FROM php:8.2-fpm

# Instala extensões necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto para o container
COPY . .

# Dá permissão à pasta storage e bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expor a porta do PHP-FPM
EXPOSE 9000

# Comando de entrada
CMD ["php-fpm"]
