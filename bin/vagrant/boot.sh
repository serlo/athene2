#!/bin/sh

# sudo cp -R /vagrant/dist/solr/* /etc/solr/conf/
sudo service tomcat6 restart
# mkdir /vagrant/src/public/assets
rm /vagrant/src/data/* -rf
# sudo su - www-data -c "(cd /vagrant/src/assets;npm cache clean)"
# sudo su - www-data -c "(cd /vagrant/src/assets;npm install)"
# sudo su - www-data -c "(cd /vagrant/src/assets;npm update)"
pm2 start /vagrant/src/assets/node_modules/athene2-editor/server/server.js --node-args="--expose_gc --gc_global"
# sudo su - www-data -c "(cd /vagrant/src/assets;bower cache clean)"
# sudo su - www-data -c "(cd /vagrant/src/assets;bower --config.analytics=false update)"
# sudo su - www-data -c "(cd /vagrant/;COMPOSER_PROCESS_TIMEOUT=5600 php composer.phar install -o)"
# sudo su - www-data -c "(cd /vagrant/;COMPOSER_PROCESS_TIMEOUT=5600 php composer.phar update -o)"
# sudo grunt dev &
