FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
      zip unzip \
      git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
