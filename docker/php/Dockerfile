FROM php:7.2-fpm-alpine

# Start from production config
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html

COPY ./composer.json .
COPY ./src/config ./src/config
COPY ./src/lang ./src/lang
COPY ./src/module ./src/module
COPY ./src/public ./src/public

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"\
  && php -r "if (hash_file('sha384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"\
  && php composer-setup.php\
  && php -r "unlink('composer-setup.php');"

# Install dependencies
RUN php composer.phar install --optimize-autoloader
