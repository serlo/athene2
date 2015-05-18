#!/bin/sh

sudo rm /var/www/src/data/* -R
sudo service apache2 restart
sudo chown www-data:www-data /var/www* -R
sudo chmod 777 /var/www -R