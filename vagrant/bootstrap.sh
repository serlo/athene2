#!/usr/bin/env bash

# Hands off configuration of mysql-server
echo "mysql-server-5.5 mysql-server/root_password password athene2" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password_again password athene2" | debconf-set-selections

# Hands off configuration of phpmyadmin
echo 'phpmyadmin phpmyadmin/dbconfig-install boolean true' | debconf-set-selections
echo 'phpmyadmin phpmyadmin/app-password-confirm password athene2' | debconf-set-selections
echo 'phpmyadmin phpmyadmin/mysql/admin-pass password athene2' | debconf-set-selections
echo 'phpmyadmin phpmyadmin/mysql/app-pass password athene2' | debconf-set-selections
echo 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2' | debconf-set-selections

# Install basic stuff
apt-get -y update
apt-get install -y python-software-properties python g++ make python-software-properties
apt-get install -y apache2 mysql-server-5.5 git
apt-get install -y language-pack-de-base inotify-tools

# Add repositories with current versions
sudo add-apt-repository -y ppa:chris-lea/node.js
sudo add-apt-repository -y ppa:ondrej/php5
sudo add-apt-repository -y ppa:muffinresearch/sass-3.2
sudo add-apt-repository -y ppa:muffinresearch/compass
apt-get -y update

# Install php

apt-get install -y libapache2-mod-php5 php5 php5-intl php5-mysql php5-curl php-pear phpmyadmin
apt-get install -y php5-xdebug php5-cli php-apc php-xml-parser
apt-get install -y solr-tomcat

# Install nodejs related stuff

apt-get install -y nodejs
apt-get install -y npm --unsafe-perm
apt-get install -y ruby-sass
apt-get install -y ruby-compass
usermod -a -G vagrant www-data

# Install npm dependencies

npm -g install bower
npm -g install grunt
npm -g install grunt-cli
npm -g install pm2 --unsafe-perm
npm -g install dnode

# HHVM
sudo add-apt-repository ppa:mapnik/boost
wget -O - http://dl.hhvm.com/conf/hhvm.gpg.key | sudo apt-key add -
echo deb http://dl.hhvm.com/ubuntu precise main | sudo tee /etc/apt/sources.list.d/hhvm.list
sudo apt-get update
sudo apt-get install -y hhvm

# VirtualHost setup
echo "<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	ServerName  localhost
	SetEnv APPLICATION_ENV \"development\"

	DocumentRoot /var/www/src/public/

	# ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:9000/var/www/src/public

	<Directory />
		Options FollowSymLinks
		AllowOverride None
	</Directory>
	<Directory /var/www/src/public/>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

	Alias /phpmyadmin /usr/share/phpmyadmin

	<Directory /usr/share/phpmyadmin>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>
</VirtualHost>" > /etc/apache2/sites-available/athene2.conf

echo '
# Listen and start after the vagrant-mounted event
start on vagrant-mounted
stop on runlevel [!2345]

exec /home/vagrant/bin/boot.sh
' > /etc/init/athene2startup.conf

# Xdebug fix
sed -i '$ a\xdebug.max_nesting_level = 500' /etc/php5/apache2/php.ini

ln -s /vagrant/bin/ /home/vagrant/bin

# Enable apache mods
a2enmod rewrite proxy proxy_fcgi
a2ensite athene2

# Restart apache
service apache2 restart

# Mysql
sudo sed -i "s/bind-address.*=.*/bind-address=0.0.0.0/" /etc/mysql/my.cnf

# Install crontab
# echo "*/10 * * * * cd /var/www/src && php public/index.php notification worker" >> cron
# crontab cron
# rm cron

# Php hacks
sudo sed -i "s/\;pcre\.backtrack\_limit=100000/pcre\.backtrack\_limit=10000/" /etc/php5/cli/php.ini
sudo sed -i "s/\;pcre\.backtrack\_limit=100000/pcre\.backtrack\_limit=10000/" /etc/php5/apache2/php.ini
sudo sed -i "s/\memory\_limit=128M/memory\_limit=512M/" /etc/php5/apache2/php.ini
sudo sed -i "s/\upload\_max\_filesize = .*M/upload\_max\_filesize = 128M/" /etc/php5/apache2/php.ini
sudo sed -i "s/\post\_max\_size = .*M/post\_max\_size = 128M/" /etc/php5/apache2/php.ini
sudo echo "apc.enabled = 1" >> /etc/php5/cli/php.ini
sudo echo "apc.enable_cli = 1" >> /etc/php5/cli/php.ini

sudo su - www-data -c "(cd /var/www/;COMPOSER_PROCESS_TIMEOUT=5600 php composer.phar install)"

# Restart apache
sudo a2dissite 000-default
sudo service apache2 restart

chmod +x /home/vagrant/bin/*
sudo /home/vagrant/bin/clean-caches.sh
sudo /home/vagrant/bin/clean-ui.sh
sudo /home/vagrant/bin/boot.sh
sudo /home/vagrant/bin/update-mysql.sh

# Restart apache
service apache2 restart
