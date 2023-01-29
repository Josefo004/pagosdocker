FROM php:5.6-apache

# Instalamos algunos paquetes en linux
RUN apt-get update -yqq \
  && apt-get install -yqq --no-install-recommends \
    git \
    zip \
    unzip \
  && rm -rf /var/lib/apt/lists

RUN apt-get update

# Instalamos Postgres PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql 

# Copiamos TODO el contenido de la carpeta actual a /var/www/html
COPY . /var/www/html

# Exponemos esta IMAGEN por el pouerto 80 de Docker
EXPOSE 80
