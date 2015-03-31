#!/bin/sh
# 
# Delete all node and bower packages, reinstall & update them, build assets
# 
# Use 'sudo su www-data -c "grunt dev"' in /var/www/src/assets to update
# assets during development (while synchronizing via 'vagrant rsync-auto')
# 
set -e

cd /var/www/src/assets

echo "removing automatically installed packages"

# clear as root
sudo -H sh -c "rm -rf node_modules build"

echo "(re)installing packages"

# www-data needs all the permissions
sudo -u www-data -H sh -c "npm install && npm update && bower install && bower update && grunt build"
