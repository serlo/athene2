#!/bin/sh

executeIn() {
    (cd $1; $2)
}

initAthene() {
    DIR="/vagrant/src/assets"

    executeIn $DIR "npm install"
    executeIn $DIR "bower --config.analytics=false install"
    executeIn $DIR "grunt build --force"
}

startEditor() {
    pm2 start server/server.js --node-args="--expose_gc --gc_global"
}

initEditor() {
    DIR="/vagrant/src/assets/athene2-editor"

    executeIn $DIR "npm install"
    executeIn $DIR "bower --config.analytics=false install"
    executeIn $DIR startEditor
}
