FROM php:8.4-fpm

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpq-dev

RUN docker-php-ext-install pdo_pgsql && docker-php-ext-enable pdo_pgsql
