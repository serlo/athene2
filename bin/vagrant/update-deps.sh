#!/bin/sh

sudo cp /vagrant/dist/solr/data-config.xml /etc/solr/conf/data-config.xml
sudo cp /vagrant/dist/solr/schema.xml /etc/solr/conf/schema.xml
cd /vagrant/src/assets && npm cache clean
cd /vagrant/src/assets && npm install && npm update
cd /vagrant/src/assets && bower cache clean
cd /vagrant/src/assets && bower update
cd /vagrant/src/assets && grunt build
pm2 start /vagrant/src/assets/node_modules/athene2-editor/server/server.js --node-args="--expose_gc --gc_global"
cd /vagrant/ && COMPOSER_PROCESS_TIMEOUT=5600 php composer.phar update -o