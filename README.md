# Athene2

[![Build Status](https://travis-ci.org/serlo-org/athene2.svg)](https://travis-ci.org/serlo-org/athene2) [![Kanban board](https://img.shields.io/badge/Kanban-board-brightgreen.svg)](https://github.com/serlo-org/athene2/projects/1)

## Documentation

* [Development workflow](https://github.com/serlo-org/athene2/wiki/Development-workflow)
* [Knowledge base](https://github.com/serlo-org/athene2/wiki/Knowledge-base)
* [outdated Athene2 Guide](https://serlo-org.github.io/athene2-guide/)

## Installing

You need [Docker](https://docs.docker.com/engine/installation/) php-cli and node installed on your system.
To build the assets you also need to install ruby-sass and ruby-compass installed.

On Windows we recommend [Bash on Ubuntu on Windows](https://msdn.microsoft.com/de-de/commandline/wsl/about). You can
install the dependencies above (except Docker) with:

```
sudo apt-get install php5-cli nodejs ruby-sass ruby-compass4
```

**WARNING** `ruby.cionoass` must be in version range `0.12.2` and `ruby-sass` must be in version range `3.2.10` - check this with
`compass version` and `sass -v`. If versions mismatch, building the assets will fail!

Now follow the upcoming instructions.

### Clone the project

```sh
# Clone the project and its submodules:
$ git clone git@github.com:serlo-org/athene2.git --recursive

$ cd athene2
```

If you forgot to clone recursively, you can also do this to fetch the submodules:

```sh
$ git submodule update --init --recursive
```

### Bootstrapping the project

If you are on windows, run the following in Bash on Windows:

```sh
# Copy some config files
$ cp src/config/autoload/local.php.dist src/config/autoload/local.php
$ cp src/config/autoload/develop.local.php.dist src/config/autoload/develop.local.php
$ cp src/public/htaccess.dist src/public/.htaccess

# Install various dependencies
$ php composer.phar install

# Install and build the assets
$ (cd src/assets; npm install; npm run build)
$ (cd src/assets/athene2-editor; npm install; npm run build)
```

Now you can start the cluster:

```
# Start the docker-compose cluster.
# ps: The database import might take some time (1-10 minutes).

# If you are on Windows, run this in regular cmd.exe

$ docker-compose up --build
```

### Setting up hosts

On windows, please add

```
127.0.0.1 de.serlo.localhost
127.0.0.1 en.serlo.localhost
```

to your `C:\Windows\System32\drivers\etc\hosts.txt` file. Then run `ipconfig /flushdns` in cmd.exe and
restart your browser.

On linux/osx:

```
tbd @knorrke/@inyono
```

Now, open [de.serlo.localhost:4567](de.serlo.localhost:4567). Happy coding!