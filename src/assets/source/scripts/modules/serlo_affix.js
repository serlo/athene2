/*global define, Modernizr*/
define(['jquery', 'underscore'], function ($, _) {
    'use strict';
    var SerloAffix,
        affixQueue = {},
        useCssTransforms = Modernizr.csstransforms,
        scrollTop = 0,
        settings,
        $stickTo,
        stickToHeight,
        stickToTop,
        defaultOptions,
        throttledPositioning,
        windowHeight;

    defaultOptions = {
        stickToSelector: '#content-layout'
    };

    affixQueue.elements = [];

    affixQueue.append = function ($elem) {
        $elem.offsetTop = $elem.offset().top;
        this.elements.push($elem);
    };

    affixQueue.each = function (fn) {
        _.each(this.elements, fn);
    };

    function positionElements($elem) {
        var cssProp = {},
            scrollTop = (window.pageYOffset || document.documentElement.scrollTop) - (document.documentElement.clientTop || 0),
            top = $elem.offsetTop,
            height = $elem[0].clientHeight,
            targetTop;

        // Case 1: element has more height than window 
        // && Case 2: element height is lower than stickToElements height
        if (height > windowHeight || height > stickToHeight) {
            targetTop = 0;
        } else {
            // Case 2: element has less height than window
            if (scrollTop > top) {
                // only act, when scrollTop is high enough
                targetTop = scrollTop - top;
            } else {
                targetTop = 0;
            }

            if (height < stickToHeight && height > stickToHeight + stickToTop - scrollTop) {
                targetTop = stickToTop + stickToHeight - height - top;
            }
        }

        // Apply Styles
        if (useCssTransforms) {
            cssProp.transform = 'translateY(' + targetTop + 'px)';
            $elem.css(cssProp);
            // cssProp.top = targetTop + 'px';
        } else {
            cssProp.top = targetTop + 'px';

            $elem.animate(cssProp, {
                queue: false
            });
        }
    }

    function resetElements($elem) {
        var cssProp = {};

        // Apply Styles
        if (useCssTransforms) {
            cssProp.transform = 'translateY(' + 0 + 'px)';
            $elem.css(cssProp);
            // cssProp.top = 0 + 'px';
        } else {
            cssProp.top = 0 + 'px';

            $elem.animate(cssProp, {
                queue: false
            });
        }

        $elem.offsetTop = $elem.offset().top;
    }

    throttledPositioning = _.throttle(function () {
        affixQueue.each(positionElements);
    }, 60, {
        leading: false
    });

    function affixOnScroll() {
        scrollTop = $('body,html').scrollTop();
        windowHeight = window.outerHeight || $(window).height();

        stickToTop = $stickTo.offset().top;
        stickToHeight = $stickTo.height();

        affixQueue.each(positionElements);
    }

    function affixOnResize() {
        affixQueue.each(resetElements);
        affixOnScroll();
    }

    $(window)
        .scroll(affixOnScroll);
    $(window)
        .resize(affixOnResize);

    SerloAffix = function (options) {
        var $elements = $(this);

        settings = $.extend({}, defaultOptions, options);

        $stickTo = $(settings.stickToSelector);

        return $elements.each(function () {
            // for now: ignore touch devices
            if (!Modernizr.touch) {
                affixQueue.append($(this));
            }
        });
    };

    $.fn.SerloAffix = SerloAffix;
});
