/*global define, window, Modernizr*/
define(['jquery', 'underscore'], function ($, _) {
    "use strict";
    var SideElement,
        defaults = {
            visibleClass: 'visible',
            // Full Stack Breakpoint Grid
            fullStackBreakPoint: 1350,
            // Sidebar Breakpoint Grid
            sidebarBreakPoint: 980,
            // Navigation Breakpoint Grid
            navigationBreakPoint: 1140
        };

    SideElement = function (options) {
        this.options = options ? $.extend({}, defaults, options) : $.extend({}, defaults);

        this.$window = $(window);

        this.$elements = $('.side-element');

        this.attachHandler();
    };

    SideElement.prototype.attachHandler = function () {
        var that = this;

        that.$elements.each(function () {
            var $element = $(this);

            $('.layout-toggle', $element).click(function () {
                that.$elements
                    .not($element)
                    .removeClass(that.options.visibleClass);

                $element.toggleClass(that.options.visibleClass);
            });
        });

        if (!Modernizr.touch) {
            that.$window.resize(_.debounce(function () {
                that.$elements.removeClass(that.options.visibleClass);
            }, 300));
        }
    };


    return {
        init: function (options) {
            return new SideElement(options);
        }
    };
});