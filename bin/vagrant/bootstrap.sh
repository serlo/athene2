#!/usr/bin/env bash

# Hands off configuration of mysql-server
echo "mysql-server-5.5 mysql-server/root_password password athene2" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password_again password athene2" | debconf-set-selections

# Hands off configuration of phpmyadmin
echo "phpmyadmin phpmyadmin/dbconfig-install boolean true" | debconf-set-selections
echo "phpmyadmin phpmyadmin/app-password-confirm password athene2" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-pass password athene2" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/app-pass password athene2" | debconf-set-selections
echo "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2" | debconf-set-selections

echo "deb http://archive.ubuntu.com/ubuntu/ trusty multiverse
deb-src http://archive.ubuntu.com/ubuntu/ trusty multiverse
deb http://archive.ubuntu.com/ubuntu/ trusty-updates multiverse
deb-src http://archive.ubuntu.com/ubuntu/ trusty-updates multiverse
" >> /etc/apt/sources.list

# php7
sudo add-apt-repository -y ppa:ondrej/php > /dev/null 2>&1

# Install basic stuff
apt-get -y update
apt-get install -y python-software-properties python g++ make python-software-properties
apt-get install -y apache2 apache2-mpm-event libapache2-mod-fastcgi mysql-server-5.5 git
apt-get install -y language-pack-de-base language-pack-en-base inotify-tools

# Fix apache2 fastcgi bug
chmod 777 /var/lib/apache2/fastcgi

# Install php
apt-get install -y php7.0 php7.0-common php7.0-fpm php7.0-opcache php7.0-intl  php7.0-cli php7.0-mysql php7.0-curl libapache2-mod-php7.0 php7.0-modules-source
apt-get install -y solr-tomcat

# Install nodejs related stuff
apt-get install -y nodejs nodejs-legacy
apt-get install -y npm
apt-get install -y ruby-sass
apt-get install -y ruby-compass

# Install npm dependencies
npm -g install bower
npm -g install grunt
npm -g install grunt-cli
npm -g install pm2 --unsafe-perm
npm -g install dnode

git clone https://github.com/krakjoe/apcu.git /home/vagrant/apcu
cd /home/vagrant/apcu && phpize && ./configure && make && make install

# VirtualHost setup
echo "<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	ServerName  localhost
	SetEnv APPLICATION_ENV \"development\"

	DocumentRoot /var/www/src/public/

	<Directory />
		Options FollowSymLinks
		AllowOverride None
	</Directory>

	<Directory /var/www/src/public>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		Allow from all
	</Directory>

	Alias /phpmyadmin /usr/share/phpmyadmin

	<Directory /usr/share/phpmyadmin>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

</VirtualHost>" > /etc/apache2/sites-available/athene2.conf

a2ensite athene2
a2dissite 000-default

# Install boot script at boot time
echo "
# Listen and start after the vagrant-mounted event
start on vagrant-mounted
stop on runlevel [!2345]

exec su vagrant -c /vagrant/bin/vagrant/boot.sh >> /home/vagrant/boot.log
" > /etc/init/athene2startup.conf

# Xdebug fix
sed -i "$ a\xdebug.max_nesting_level = 500" /etc/php7/apache2/php.ini

# Change Apache User to vagrant
sed -i "s/www-data/vagrant/g" /etc/apache2/envvars
# Just to be safe...
usermod -a -G vagrant www-data

# Setup /vagrant
rm -rf /var/www
ln -s /vagrant /var/www
mkdir /vagrant/src/data/ /vagrant/src/public/assets /vagrant/src/logs/
chown -R vagrant:vagrant /vagrant
chmod -R 777 /vagrant

# Enable Apache mods
a2enmod rewrite proxy proxy_fcgi headers actions

# MySQL
sed -i "s/bind-address.*=.*/bind-address=0.0.0.0/" /etc/mysql/my.cnf

# Install crontab
# echo "*/10 * * * * cd /vagrant/src && php public/index.php notification worker" >> cron
# crontab cron
# rm cron

# Php hacks
sed -i "s/\;pcre\.backtrack\_limit=100000/pcre\.backtrack\_limit=10000/" /etc/php/7.0/cli/php.ini
sed -i "s/\;pcre\.backtrack\_limit=100000/pcre\.backtrack\_limit=10000/" /etc/php/7.0/fpm/php.ini
sed -i "s/\memory\_limit = 128M/memory\_limit = 1024M/" /etc/php/7.0/cli/php.ini
sed -i "s/\upload\_max\_filesize = .*M/upload\_max\_filesize = 128M/" /etc/php/7.0/cli/php.ini
sed -i "s/\post\_max\_size = .*M/post\_max\_size = 128M/" /etc/php/7.0/cli/php.ini
echo "
# APC
extension=apcu.so
extension=apc.so
apc.enabled=1
" >> /etc/php/7.0/fpm/php.ini

echo "
# APC
extension=apcu.so
extension=apc.so
apc.enabled=1
apc.enable_cli = 1
" >> /etc/php/7.0/cli/php.ini


listen.mode = 0666

su vagrant - -c "(cd /vagrant/;COMPOSER_PROCESS_TIMEOUT=5600 php composer.phar install)"

# execute scripts
su vagrant - -c "/vagrant/bin/vagrant/update-mysql.sh"
su vagrant - -c "(cd /vagrant/src/assets; npm install; bower --config.analytics=false install)"

# Restart apache
service apache2 restart

# change to src directory on vagrant ssh
echo "cd /vagrant" >> /home/vagrant/.bashrc
