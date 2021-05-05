FROM php:7.3-fpm-stretch

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_NO_INTERACTION 1

RUN apt-get update && apt-get install -y git cron zip unzip vim

RUN apt-get update && apt-get install libmagickwand-dev -y --no-install-recommends \
  && pecl install imagick-3.4.3 \
  && docker-php-ext-enable imagick

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
ADD . /var/www/html

COPY cronfile /etc/cron.d/cronfile
RUN chmod 0644 /etc/cron.d/cronfile
RUN crontab /etc/cron.d/cronfile
RUN touch /var/log/cron.log
CMD cron && tail -f /var/log/cron.log
