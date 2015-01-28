#!/bin/sh

sudo su - www-data -c "cd /var/www/src && php public/index.php notification worker"