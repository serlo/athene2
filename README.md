# Athene2

[![Build Status](https://travis-ci.org/serlo-org/athene2.svg)](https://travis-ci.org/serlo-org/athene2) [![Kanban board](https://img.shields.io/badge/Kanban-board-brightgreen.svg)](https://github.com/serlo-org/athene2/projects/1)

## Documentation

* [Development workflow](https://github.com/serlo-org/athene2/wiki/Development-workflow)
* [Knowledge base](https://github.com/serlo-org/athene2/wiki/Knowledge-base)
* [outdated Athene2 Guide](https://serlo-org.github.io/athene2-guide/)

## Installing

You need [Docker](https://docs.docker.com/engine/installation/) php-cli and node installed on your system.
On Windows we recommend [Bash on Ubuntu on Windows](https://msdn.microsoft.com/de-de/commandline/wsl/about)
and installing with `php apt-get install php5-cli nodejs`. Then follow the upcoming instructions

### Clone the project

```sh
# Clone the project and its submodules:
$ git clone git@github.com:serlo-org/athene2.git --recursive

$ cd athene2
```

If you forgot to clone recursively, you can also do this to fetch the submodules:

```sh
$ git submodule update --recursive --remote
```

### Bootstrapping the project

```sh
# Copy some config files
$ cp src/config/autoload/local.php.dist src/config/autoload/local.php
$ cp src/config/autoload/develop.local.php.dist src/config/autoload/develop.local.php
$ cp src/public/htaccess.dist src/public/.htaccess

# Install various dependencies
$ php composer.phar install
$ (cd src/assets; npm install)
$ (cd src/assets; npm install)

# Start the docker-compose cluster
$ docker-compose up --build
```
