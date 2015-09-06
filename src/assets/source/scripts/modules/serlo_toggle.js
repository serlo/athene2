/*global define*/
define(['jquery'], function ($) {
    "use strict";
    var CollapseScrollHelper,
        ToggleAction;

    CollapseScrollHelper = (function () {
        var base = null,
            resizeInterval = null,
            offset,
            win = $(window),
            scrollPos,
            minScrollPos,
            onResize;

        onResize = function () {
            offset = (base.offset().top + base.height()) - (win.scrollTop() + win.height());
            if (offset > 0) {
                scrollPos = base.offset().top + base.height() - win.height();

                // it would be better to use the real height of the navigation here, but due to
                //  attributes like box shadow, the height is not very easy to determine
                //  so a fixed value of 70px is used instead
                minScrollPos = base.offset().top - 70;
                win.scrollTop(Math.min(scrollPos, minScrollPos));
            }
        };

        return {
            startCollapse: function (baseElement) {
                base = baseElement;

                if (resizeInterval) {
                    clearInterval(resizeInterval);
                    resizeInterval = null;
                }

                if (base) {
                    // the delay might be larger due to performance reasons
                    //  but could also be smaller for a smoother scrolling
                    resizeInterval = setInterval(onResize, 20);
                }
            },

            stopCollapse: function () {
                if (resizeInterval) {
                    clearInterval(resizeInterval);
                    resizeInterval = null;
                }
            }
        };
    })();

    ToggleAction = function () {
        return $(this).each(function () {
            // Edit mode toggle
            if ($(this).data('toggle') === 'edit-controls') {
                $(this)
                    .unbind('click')
                    .click(function (e) {
                        e.preventDefault();
                        var $that = $(this);
                        $that.toggleClass('active');
                        $('.edit-control').toggleClass('hidden');
                        return false;
                    });
            } else if ($(this).data('toggle') === 'discussions') {
                $(this)
                    .unbind('click')
                    .click(function (e) {
                        e.preventDefault();
                        var $that = $(this),
                            $target = $($that.data('target'));
                        $that.toggleClass('active');
                        $target.toggleClass('hidden');
                        $('html, body').animate({
                            scrollTop: $target.offset().top
                        }, 500);
                        return false;
                    });
            } else if ($(this).data('toggle') === 'visibility') {
                $(this)
                    .unbind('click')
                    .click(function () {
                        var $that = $(this),
                            $target = $($that.data('target'));
                        $target.toggleClass('hidden');
                    });
            } else if ($(this).data('toggle') === 'collapse') {
                if (/#solution-\d+/.test($(this).data('target'))) {
                    var $target = $($(this).data('target')),
                        $base = $(this).closest('article');

                    if (!$base.length) {
                        $base = $target;
                    }

                    $target
                        .on('show.bs.collapse', function (event) {
                            if ($(this).is($(event.target))) {
                                CollapseScrollHelper.startCollapse($base);
                            }
                        })
                        .on('shown.bs.collapse', function (event) {
                            if ($(this).is($(event.target))) {
                                CollapseScrollHelper.stopCollapse();
                            }
                        });
                }
            }
        });
    };

    $.fn.ToggleAction = ToggleAction;
});