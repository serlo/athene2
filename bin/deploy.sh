#!/bin/bash

# load nvm env vars
source ~/.profile

cd "$(dirname "$0")"

git status
git pull
git submodule update --init --recursive
sh templatemap_generator.sh
sh build.sh

pm2 stop server
pm2 delete server
cd ../src/assets/athene2-editor
npm update
bower update
grunt build
pm2 start server/server.js

cd ../../

pm2 status

cd ..
php composer.phar update -o

rm src/data/twig src/data/zfc* src/data/*.php src/data/*.cache -Rf
rm src/data/*.php -Rf
php src/public/index.php pagespeed build
