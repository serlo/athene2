/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author  Julian Kempff (julian.kempff@serlo.org)
 * @license LGPL-3.0
 * @license http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * 
 * Saves the browser pathname on the client side.
 */

/*global define, window*/
define(["underscore", "cache", "events"], function (_, cache) {
    "use strict";
    var ReferrerHistory,
        cacheKey = 'a2_history',
        limit = 50,
        historyCache = cache(cacheKey);

    /**
     * loads history from cache
     * or creates a new one
     **/

    ReferrerHistory = function () {
        historyCache.json = true;
        this.history = historyCache.remember();
        if (!this.history || typeof this.history === 'string') {
            this.history = [];
        }

        this.addCurrent();
    };

    /**
     * updates the client side storage
     **/
    ReferrerHistory.prototype.update = function () {
        historyCache.memorize(this.history);
    };

    /**
     * empties history
     **/
    ReferrerHistory.prototype.clear = function () {
        this.history = [];
        this.update();
    };

    /**
     * adds the current pathname to history,
     * if the last added path !== current path
     * always sorts the last added path to the end
     * of history
     **/
    ReferrerHistory.prototype.addCurrent = function () {
        var path = window.location.pathname;
        if (this.getOne() !== path) {
            // if the path exists in history
            if (this.isInHistory(path) >= 0) {
                // delete it from history
                this.history.splice(this.isInHistory(path), 1);
            }

            this.history.push(window.location.pathname);

            if (this.history.length > limit) {
                this.history.shift();
            }

            this.update();
        }
    };

    /**
     * returns the index of the existing path or -1
     **/
    ReferrerHistory.prototype.isInHistory = function (pathname) {
        return _.indexOf(this.history, pathname);
    };

    /**
     *  returns an array of the last n'th paths in history
     **/
    ReferrerHistory.prototype.getRange = function (n) {
        var length = this.history.length;
        return this.history.slice(length - (n || 1));
    };

    /**
     * returns one by index
     **/
    ReferrerHistory.prototype.getOne = function (index) {
        return this.history[index === undefined ? this.history.length - 1 : index];
    };

    /**
     * returns all
     **/
    ReferrerHistory.prototype.getAll = function () {
        return this.getRange(this.history.length);
    };

    /**
     * returns current item
     **/
    ReferrerHistory.prototype.getCurrent = function () {
        return this.getOne();
    };

    /**
     * returns current item
     **/
    ReferrerHistory.prototype.getPrevious = function () {
        return this.getOne(this.history.length - 2);
    };

    return new ReferrerHistory();
});