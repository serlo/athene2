#!/bin/sh

cleanDependencies() {
    npm cache clean
    bower cache clean
    rm -R node_modules/*
    rm -R source/bower_components/*
    npm install
    bower --config.analytics=false install
}

pm2 kill

cd /vagrant/src/assets
cleanDependencies
grunt build

cd /vagrant/src/assets/athene2-editor;
cleanDependencies
pm2 start server/server.js --node-args="--expose_gc --gc_global"
