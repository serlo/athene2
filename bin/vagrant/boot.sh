#!/bin/sh

DIR="$(dirname "$0")"

. "${DIR}/../helpers.sh"

sudo cp -R /vagrant/dist/solr/* /etc/solr/conf/
sudo service tomcat6 restart
rm /vagrant/src/data/* -rf

initAthene
initEditor
