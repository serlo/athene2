#!/bin/sh

git status
git pull
git submodule update --init --recursive
sh templatemap_generator.sh
sh build.sh

pm2 stop server
pm2 delete server
cd ../src/assets/
npm update

cd athene2-editor
npm update
bower update
# pm2 start -i 0 --max-memory-restart 600M node_modules/athene2-editor/server/server.js --node-args="--expose_gc --gc_global"
pm2 start server/server.js
cd ../

bower update
grunt build
cd ../../
cd src

php public/index.php assetic build
pm2 status

cd ../
php composer.phar update -o

rm src/data/twig data/zfc* src/data/*.php src/data/*.cache -Rf
rm src/data/*.php -Rf
php src/public/index.php pagespeed build
