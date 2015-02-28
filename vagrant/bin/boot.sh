#!/bin/sh

rm /var/www/src/data/* -rf
chown www-data:www-data /var/www/src/data
sudo su - www-data -c "(cd /var/www/src/assets;npm cache clean)"
sudo su - www-data -c "(cd /var/www/src/assets;npm update)"
sudo su - www-data -c "(cd /var/www/src/assets;bower cache clean)"
sudo su - www-data -c "(cd /var/www/src/assets;bower --config.analytics=false update)"
sudo su - www-data -c "pm2 start /var/www/src/assets/node_modules/athene2-editor/server/server.js"
sudo su - www-data -c "(cd /var/www/;COMPOSER_PROCESS_TIMEOUT=5600 php composer.phar update -o)"
sudo su - www-data -c "grunt dev &"
