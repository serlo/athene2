#!/bin/sh

DIR="$(dirname "$0")"

sudo cp /vagrant/dist/solr/data-config.xml /etc/solr/conf/data-config.xml
sudo cp /vagrant/dist/solr/schema.xml /etc/solr/conf/schema.xml

"${DIR}/clean-ui.sh"

cd /vagrant
COMPOSER_PROCESS_TIMEOUT=5600 php composer.phar update -o
