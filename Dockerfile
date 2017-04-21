FROM php:7.1.4-apache

RUN sed -ie 's/\/var\/www\/html/\/var\/www\/html\/src\/public/g' /etc/apache2/sites-enabled/000-default.conf

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

COPY . /var/www/html

VOLUME /var/www/html

EXPOSE 80