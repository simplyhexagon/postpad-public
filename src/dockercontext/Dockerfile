FROM php:8.2.4-apache-bullseye
RUN apt-get update -y && apt-get upgrade -y
RUN docker-php-ext-install mysqli
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN a2enmod rewrite