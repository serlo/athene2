/*global define*/
define(['jquery', 'underscore', 'common', 'translator', 'router'], function ($, _, Common, t, Router) {
    "use strict";
    var Search,
        SearchResults,
        defaults = {
            url: '/search/ajax',
            wrapperSelector: '#search-content',
            inputSelector: '#search-input',
            resultWrapper: '#search-results',
            inFocusClass: 'is-in-focus',
            hasResultsClass: 'has-results',
            ajaxThrottling: 360,
            maxQueryLength: 3,
            ignoreKeys: [
                Common.KeyCode.shift,
                Common.KeyCode.backspace,
                Common.KeyCode.entf,
                Common.KeyCode.cmd,
                Common.KeyCode.up,
                Common.KeyCode.down
            ]
        };

    SearchResults = function (resultWrapperClass, $input) {
        this.$el = $(resultWrapperClass);
        this.$input = $input;
        this.clear();
    };

    SearchResults.prototype.clear = function () {
        this.activeFocus = -1;
        this.$el.empty();
    };

    SearchResults.prototype.show = function (groups) {
        var self = this;
        self.clear();
        self.count = 0;

        _.each(groups, function (group) {
            var $li = $('<li class="header">').append(group.title);
            self.$el.append($li);
            _.each(group.items, function (item) {
                var $li = $('<li>').append($('<a>').text(item.title).attr('href', item.url));
                self.$el.append($li);
                self.count += 1;
            });
        });

        self.$links = self.$el.find('li').filter(':not(.header)');

        this.setActiveItem();
    };

    SearchResults.prototype.onKey = function (e, isSearching, xhr) {
        switch (e.keyCode) {
        case Common.KeyCode.up:
            e.preventDefault();
            this.focusPrev();
            return;
        case Common.KeyCode.down:
            e.preventDefault();
            this.focusNext();
            return;
        case Common.KeyCode.enter:
            //if (isSearching) {
            //    break;
            //}

            if (xhr) {
                xhr.abort('stop');
            }

            //if (undefined !== this.$links && this.$links.length && this.activeFocus !== -1) {
            //    Router.navigate(this.$links.eq(this.activeFocus).children().first().attr('href'));
            //    this.$input.blur();
            //} else {
            Router.navigate('/search?q=' + this.$input.val());
            //}
            break;
        }
    };

    SearchResults.prototype.focusNext = function () {
        this.activeFocus += 1;
        if (this.activeFocus >= this.count) {
            this.activeFocus = -1;
        }
        this.setActiveItem();
    };

    SearchResults.prototype.focusPrev = function () {
        this.activeFocus -= 1;
        if (this.activeFocus < -1) {
            this.activeFocus = this.count - 1;
        }
        this.setActiveItem();
    };

    SearchResults.prototype.setActiveItem = function () {
        this.$el.find('.active').removeClass('active');
        if (this.activeFocus !== -1) {
            var $next = this.$links.eq(this.activeFocus);
            if ($next.length) {
                $next.addClass('active');
            }
        }
    };

    SearchResults.prototype.noResults = function (string) {
        var $li = $('<li class="header">').text(t('No results found for "%s".', string));
        this.$el.append($li);
    };

    Search = function (options) {
        var self = this;

        self.options = $.extend({}, defaults, options || {});
        self.isSearching = false;
        self.$el = $(self.options.wrapperSelector);
        self.$input = $(self.options.inputSelector);
        self.results = new SearchResults(self.options.resultWrapper, self.$input);

        self.origPerformSearch = self.performSearch;
        self.performSearch = _.throttle(function (string) {
            self.origPerformSearch(string);
        }, self.options.ajaxThrottling);

        self.attachHandler();
    };

    Search.prototype.attachHandler = function () {
        var self = this;
        this.$input
            .focus(function () {
                self.$el.addClass(self.options.inFocusClass);

                // Keep track on the users mouse actions
                // to prevent too fast result clearing
                self.$el.mousedown(function () {
                    self.onMouseDown();
                });
                self.$el.mouseup(function () {
                    self.onMouseUp();
                });
            })
            .bind('focusout', function () {
                function clearAndHide() {
                    self.results.clear();
                    self.$el.removeClass(self.options.inFocusClass).removeClass(self.options.hasResultsClass);
                    self.$el.unbind('mousedown').unbind('mouseup');
                }

                // If the user currently has the mouse down
                // on self.$el, he probably wants to click
                // on a search result. So we set a timeout
                // to make sure the results dont disappear
                // before the user can click on them.
                if (self.mouseIsDown) {
                    setTimeout(function () {
                        clearAndHide();
                    }, 400);
                } else {
                    clearAndHide();
                }
            })
            .keyup(function (e) {
                var value = Common.trim($(this).val() || "");

                self.results.onKey(e, self.isSearching, self.ajax);

                if (_.indexOf(self.options.ignoreKeys, e.keyCode) >= 0) {
                    return true;
                }

                switch (e.keyCode) {
                case Common.KeyCode.esc:
                    self.$input.blur();
                    break;
                default:
                    Common.expr(value.length < self.options.maxQueryLength || self.search(value));
                    break;
                }
            });
    };

    Search.prototype.onMouseDown = function () {
        this.mouseIsDown = true;
    };

    Search.prototype.onMouseUp = function () {
        this.mouseIsDown = false;
    };

    Search.prototype.search = function (string) {
        this.performSearch(string);
    };

    Search.prototype.performSearch = function (string) {
        var self = this;

        self.isSearching = true;

        if (self.ajax) {
            self.ajax.abort();
        }

        self.ajax = $.ajax({
            url: self.options.url,
            data: {
                q: string
            },
            method: 'post'
        });

        self.ajax.success(function (data) {
            // Only do anything if this
            // was the last xhr call!
            if (arguments[2] === self.ajax) {
                if (typeof data !== 'object' || data.length === 0) {
                    // self.onNoResult(string);
                } else {
                    // self.onResult(data);
                }
                self.isSearching = false;
            }
        }).error(function () {
            // xhr object has been aborted
            // simply ignore.
            if (arguments[1] === 'abort' || arguments[1] === 'stop') {
                return;
            }
            self.$input.blur();
        });
    };

    Search.prototype.onResult = function (result) {
        if (this.$el.hasClass(this.options.inFocusClass)) {
            this.results.clear();
            this.$el.addClass(this.options.hasResultsClass);
            this.results.show(result);
        }
    };

    Search.prototype.onNoResult = function (string) {
        if (this.$el.hasClass(this.options.inFocusClass)) {
            this.results.clear();
            this.$el.addClass(this.options.hasResultsClass);
            this.results.noResults(string);
        }
    };

    return Search;
});