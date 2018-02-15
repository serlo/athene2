Athene2 Editor
==============

You'll need [NodeJS](http://nodejs.org) and [Ruby gems](https://www.ruby-lang.org) installed. Also make sure that bower and grunt are installed:

```
npm install bower -g
npm install grunt-cli -g
gem update --system
gem install compass --version 0.12.2
gem install sass --version 3.2.10
```

Now, install the packages needed by the Editor:

```
npm install
bower install
grunt dev
```

Open [localhost:9001](http://localhost:9001)
