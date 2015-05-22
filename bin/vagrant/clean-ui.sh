#!/bin/sh

pm2 kill
(cd /vagrant/src/assets;npm cache clean)
(cd /vagrant/src/assets;bower cache clean)
rm -R /vagrant/src/assets/node_modules/*
rm -R /vagrant/src/assets/source/bower_components/*
cd /vagrant/src/assets/;npm install
(cd /vagrant/src/assets;bower --config.analytics=false install)
(cd /vagrant/src/assets;grunt build)
pm2 start /vagrant/src/assets/node_modules/athene2-editor/server/server.js --node-args="----expose_gc --gc_global"