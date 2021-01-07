FROM php:7.4-apache
WORKDIR /var/www/html
RUN apt-get -y update && apt-get -y upgrade && \
    a2enmod rewrite && \
    docker-php-ext-install pdo_mysql
