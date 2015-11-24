#!/bin/sh

DIR="$(dirname "$0")"

. "${DIR}/../helpers.sh"

cleanDependencies() {
    cd $1
    npm cache clean
    bower cache clean
    rm -R node_modules/*
    rm -R source/bower_components/*
}

pm2 kill

cleanDependencies "/vagrant/src/assets"
initAthene

cleanDependencies "/vagrant/src/assets/athene2-editor"
initEditor
