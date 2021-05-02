FROM php:7.3-fpm-stretch

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_NO_INTERACTION 1

RUN apt-get update && apt-get install -y git cron zip unzip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
ADD . /var/www/html