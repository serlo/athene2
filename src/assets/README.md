The following is outdated. See [http://serlo-org.github.io/athene2-guide/ui/](http://serlo-org.github.io/athene2-guide/ui/) for instructions.

Grunt Boilerplates
==================

## Extendable Workflow for (S)CSS / Javascript / Interface Images

### Provides

* Sass + Compass --watch
* CSS autoprefixing (following googles `last 1 version` method)
* Javascript linting (Configurable in `.jshintrc`)
* [Image optimization](https://github.com/gruntjs/grunt-contrib-imagemin)
* CSS/JS minification
* Bower dependencies (jQuery, modernizr, ...Configurable in `bower.json`


### Dependencies

* [node](http://nodejs.org)
* [grunt](http://gruntjs.com/)
* [bower](http://bower.io/)
* [sass](http://sass-lang.com/) & [compass](http://compass-style.org/)

.. or simply install yeoman.

### Installation

run `npm install && bower install`

### Usage


Grunt will create a `./build` directory with where the built /styles/*.css and /scripts/*.js files are stored.


For development, type `grunt dev` to start the watch tasks, that will automatically build your css.

For production type `grunt build` or just `grunt` to test and copy all needed files into the `build` folder. Creates also *.min.js and *.min.css files.

### Example File Structure

    /* source *.scss file is located at */
    source/styles/main.scss
    /* the to-embed-in-html generated css file then is at */
    build/styles/main.min.css

    /* same goes for javascript */
    source/scripts/scripts.js // source
    build/scripts/scripts.min.js // minified/compressed
