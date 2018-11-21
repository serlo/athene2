# Athene2

[![Build status](https://img.shields.io/travis/com/serlo-org/athene2.svg)](https://travis-ci.com/serlo-org/athene2) [![Kanban board](https://img.shields.io/badge/Kanban-board-brightgreen.svg)](https://github.com/orgs/serlo-org/projects/1)

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->

- [Installation](#installation)
  - [Clone the project](#clone-the-project)
  - [Bootstrapping the project](#bootstrapping-the-project)
    - [Troubleshooting](#troubleshooting)
      - [Wrong php version](#wrong-php-version)
      - [npm install failing](#npm-install-failing)
      - [postinstall script: bower fails](#postinstall-script-bower-fails)
  - [Now you can start the cluster](#now-you-can-start-the-cluster)
  - [Setting up hosts](#setting-up-hosts)
- [Development](#development)
- [Further resources](#further-resources)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Installation

You need [Docker](https://docs.docker.com/engine/installation/), php-cli and node installed on your system.

On Windows we recommend [Bash on Ubuntu on Windows](https://msdn.microsoft.com/de-de/commandline/wsl/about).

Now follow the upcoming instructions.

### Clone the project

```sh
# Clone the project:
$ git clone https://github.com/serlo-org/athene2.git
$ cd athene2
```

### Bootstrapping the project

On Linux or macOS, just open a terminal and run the following commands. If you are on Windows, run the following in _Bash on Windows_:

```sh
# Copy some config files
$ cp docker-compose.dist.yml docker-compose.yml
$ cp src/config/autoload/local.dist.php src/config/autoload/local.php
$ cp src/config/autoload/develop.local.dist.php src/config/autoload/develop.local.php
$ cp src/public/htaccess.dist src/public/.htaccess

# Install various dependencies
$ php composer.phar install
```

### Starting docker-compose

```sh
$ docker-compose up --build -d
```

#### Troubleshooting

##### Wrong php version

If `php composer.phar install` fails with error

```sh
Your requirements could not be resolved to an installable set of packages.
 Problem 1
 - doctrine/collections v1.4.0 requires php ^5.6 || ^7.0 -> your PHP version (5.5.9) does not satisfy that requirement.
 - doctrine/collections v1.4.0 requires php ^5.6 || ^7.0 -> your PHP version (5.5.9) does not satisfy that requirement.
 - Installation request for doctrine/collections v1.4.0 -> satisfiable by doctrine/collections[v1.4.0].
```

then you can try updating php to 5.6:

```sh
$ sudo apt-get remove php5-cli
$ sudo add-apt-repository ppa:ondrej/php
$ sudo apt-get update
$ sudo apt-get install php5.6-cli
```

##### `npm install` failing

Try a different node version (i.e. using [nvm](https://github.com/creationix/nvm)). Try using node version 0.12.5

Also try cleaning the cache and rebuilding:
make sure to `cd` to the correct location first!

```sh
$ npm cache clean -f
$ npm rebuild
```

##### postinstall script: bower fails

If you get an error like `bower ESUDO Cannot be run with sudo` then try running

```sh
$ npm run bower -- --allow-root
$ npm run build
```

### Now you can start the cluster

```sh
# Start the docker-compose cluster.
# ps: The database import might take some time (1-10 minutes).

# If you are on Windows, run this in regular cmd.exe

$ docker-compose up --build
```

### Setting up hosts

On Windows, please add

```sh
127.0.0.1 de.serlo.localhost
127.0.0.1 en.serlo.localhost
```

to your `C:\Windows\System32\drivers\etc\hosts.txt` file. Then run `ipconfig /flushdns` in cmd.exe and
restart your browser.

On macOS:

```sh
sudo nano /etc/hosts

# add lines
127.0.0.1    de.serlo.localhost
127.0.0.1    en.serlo.localhost

# flush macOS DNS cache
$ sudo killall -HUP mDNSResponder
```

Now, open [de.serlo.localhost:4567](de.serlo.localhost:4567). Happy coding!

ps: `de.serlo.localhost:4567` works for me in chrome but not in FireFox. Not sure why, but if it doesn't work try
a different browser.

## Development

Development is straight forward, make your changes to the php files and then reload the browser. Done!

If you want to modify the assets (e.g. `.css`, `.js` files), you will also have to clone and set up https://github.com/serlo-org/athene2-assets. Before that, make sure you have [yarn](https://yarnpkg.com/en/docs/install) installed:

```sh
$ git clone https://github.com/serlo-org/athene2-assets
$ cd athene2-assets
$ yarn
$ yarn start
```

Furthermore, set `assets_host` to the url of webpack dev server in `src/config/autoload/develop.local.php`:

```php
return [
    // ...
    'assets_host' => 'http://localhost:8081/'
];
```

Changes to the assets will automatically reload the browser.

### Troubleshooting

#### `yarn` fails

If you got similar errors, ..

```sh
$ yarn install v1.12.3
[1/4] 🔍  Resolving packages...
[2/4] 🚚  Fetching packages...
error source-map@0.7.3: The engine "node" is incompatible with this module. Expected version ">= 8". Got "6.14.4"
error Found incompatible module
info Visit https://yarnpkg.com/en/docs/cli/install for documentation about this command.
```

.. just make sure to have the correct versions of `node` and `npm` installed:

```sh
$ node -v
$ npm -v
```

Open _package.json_ and make sure the values you got from running the two commands above match with the versions of `node` and `npm` on the document.

## Further resources

Most of these are outdated:

- [Knowledge base](https://github.com/serlo-org/athene2/wiki/Knowledge-base)
- [Development workflow (outdated)](https://github.com/serlo-org/athene2/wiki/Development-workflow)
- [Installation (totally outdated, do not look at this)](https://github.com/serlo-org/athene2/wiki/Installation)
- [Athene2 Guide (somewhat outdated)](https://serlo-org.github.io/athene2-guide/)
