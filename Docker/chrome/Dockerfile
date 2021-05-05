FROM selenium/standalone-chrome:3.141.59 

WORKDIR /var/www/html
ADD . /var/www/html

USER root

RUN curl -SL https://deb.nodesource.com/setup_12.x | bash
RUN apt-get install -y nodejs
