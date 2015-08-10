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
                // so a fixed value of 54px is used instead
                minScrollPos = base.offset().top - 60;
                win.scrollTop(Math.min(scrollPos, minScrollPos));
            }
        };

        return {
            startCollapse: function (baseElement) {
                base = baseElement;

                // the delay might be larger due to performance reasons
                //  but could also be smaller for a smoother scrolling
                resizeInterval = setInterval(onResize, 20);
            },

            stopCollapse: function () {
                if (resizeInterval !== null) {
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
                var $target = $($(this).data('target')),
                    // this is a bit messy, but i see no other way to determine
                    //  the parent element of a lesson
                    $base = $target.parent().closest('section.row, div.row');

                if ($base === null) {
                    $base = $target;
                }

                $target
                    .on('show.bs.collapse', function () {
                        CollapseScrollHelper.startCollapse($base);
                    })
                    .on('shown.bs.collapse', function () {
                        CollapseScrollHelper.stopCollapse();
                    });
            }
        });
    };

    $.fn.ToggleAction = ToggleAction;
});