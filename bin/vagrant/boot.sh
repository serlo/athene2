#!/bin/sh

sudo cp -R /vagrant/dist/solr/* /etc/solr/conf/
sudo service tomcat6 restart
rm /vagrant/src/data/* -rf
cd /vagrant/src/assets
pm2 start athene2-editor/server/server.js --node-args="--expose_gc --gc_global" -i max
grunt build
