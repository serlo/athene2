#!/bin/sh
#
#This script's purpose ...
#please check the operating system
#Please check here if git is installed
# Test whether a command exists
# $1 = cmd to test
# Usage:
# if type_exists 'git'; then
#   some action
# else
#   some other action
# fi
#

## type_exists() {
## if [ $(type -P $1) ]; then
##   return 0
## fi
## return 1
## }

#
# OS Test 
# $1 = OS 
# Usage: if is_os 'darwin'; then
#
git status
git pull -ff
sh templatemap_generator.sh
#Executes another shell containing 
#     sh classmap_generator.sh
#     sh templatemap_generator.sh
sh build.sh
pm2 stop server
pm2 delete server
cd ../src/assets/
npm update
pm2 start -i 0 --max-memory-restart 600M node_modules/athene2-editor/server/server.js --node-args="--expose_gc --gc_global"
# on error????
bower update
grunt build
cd ../../
cd src
# can we move all php calls into functions
# function PhpCall() {
#  local debug desired installed i desired_s installed_s remain
#  if [errorVar]; .....
php public/index.php assetic build
rm data/twig data/zfc* data/*.php data/*.cache -Rf
pm2 status
cd ../
php composer.phar update -o
rm data/*.php -Rf
php src/public/index.php pagespeed build
#general comment:  build in notifications ala brew.sh