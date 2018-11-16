FROM php:7.1.3-apache

RUN apt-get update -y
RUN pecl channel-update pecl.php.net

RUN apt-get install -y gettext locales libicu-dev

# Install Xdebug
RUN pecl install xdebug-2.6.1
RUN docker-php-ext-enable xdebug
RUN sed -i '1 a xdebug.remote_enable=1' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN sed -i '1 a xdebug.remote_host=host.docker.internal' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN sed -i '1 a xdebug.remote_port=9000' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Set the right path
RUN sed -ie 's/\/var\/www\/html/\/var\/www\/html\/src\/public/g' /etc/apache2/sites-available/000-default.conf

RUN docker-php-ext-install pdo pdo_mysql mysqli gettext intl
RUN pear config-set preferred_state beta
RUN yes no | pecl install apcu_bc
RUN yes DEFAULT | pecl install intl
RUN echo "extension=apcu.so" >> /usr/local/etc/php/php.ini
RUN echo "extension=apc.so" >> /usr/local/etc/php/php.ini
RUN echo "short_open_tag=Off" >> /usr/local/etc/php/php.ini

RUN locale-gen de_DE.UTF-8

# Enable Apache mods
RUN a2enmod rewrite proxy proxy_fcgi headers

RUN sed -ie 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/g' /etc/locale.gen
RUN sed -ie 's/# en_GB.UTF-8 UTF-8/en_GB.UTF-8 UTF-8/g' /etc/locale.gen
RUN sed -ie 's/# de_DE.UTF-8 UTF-8/de_DE.UTF-8 UTF-8/g' /etc/locale.gen
RUN DEBIAN_FRONTEND=noninteractive dpkg-reconfigure locales

VOLUME /var/www/html/src/config
VOLUME /var/www/html/src/lang
VOLUME /var/www/html/src/module
VOLUME /var/www/html/src/public
VOLUME /var/www/html/src/test
VOLUME /var/www/html/src/vendor

COPY ./src/init_autoloader.php /var/www/html/src/
RUN mkdir /var/www/html/src/data
RUN mkdir /var/www/html/src/logs
RUN chmod 777 -R /var/www/html/src/data /var/www/html/src/logs

EXPOSE 80

# this is outdated but maybe required later on to fix various issues

# RUN a2ensite 000-default
# COPY . /var/www/html

# Install composer
# RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# RUN php composer-setup.php
# RUN php -r "unlink('composer-setup.php');"

# Xdebug fix
# RUN sed -i "$ a\xdebug.max_nesting_level = 500" /usr/local/etc/php/php.ini

# RUN pecl install apcu
# RUN echo "extension=apcu.so" >> /usr/local/etc/php/php.ini

# Php hacks
# RUN sed -i "s/\;pcre\.backtrack\_limit=100000/pcre\.backtrack\_limit=10000/" /etc/php5/cli/php.ini
# RUN sed -i "s/\;pcre\.backtrack\_limit=100000/pcre\.backtrack\_limit=10000/" /usr/local/etc/php/php.ini
# RUN sed -i "s/\memory\_limit = 128M/memory\_limit = 1024M/" /usr/local/etc/php/php.ini
# RUN sed -i "s/\upload\_max\_filesize = .*M/upload\_max\_filesize = 128M/" /usr/local/etc/php/php.ini
# RUN sed -i "s/\post\_max\_size = .*M/post\_max\_size = 128M/" /usr/local/etc/php/php.ini

# RUN echo "apc.enabled = 1" >> /etc/php5/cli/php.ini
# RUN echo "apc.enable_cli = 1" >> /etc/php5/cli/php.ini
