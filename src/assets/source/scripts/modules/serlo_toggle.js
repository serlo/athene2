/*global define*/
define(['jquery'], function ($) {
    "use strict";
    var CollapseScrollHelper,
        ToggleAction;

    CollapseScrollHelper = (function () {
        var collapsing = null,
            resizeInterval = null,
            offset,
            win = $(window),
            scrollPos,
            minScrollPos,
            onResize;

        onResize = function () {
            offset = (collapsing.offset().top + collapsing.height()) - (win.scrollTop() + win.height());
            if (offset > 0) {
                scrollPos = collapsing.offset().top + collapsing.height() - win.height();

                // first i wanted to use the height of #subject-nav as indicator for the additional offset,
                //  but due to attributes like box shadow or margin, the real height of navigation
                //  is not so easy to determine, so a constant value of 54px is used instead
                minScrollPos = collapsing.offset().top - 60;
                win.scrollTop(Math.min(scrollPos, minScrollPos));
            }
        };

        return {
            startCollapse: function (collapsingElement) {
                collapsing = collapsingElement;

                // the delay might be larger due to performance reasons
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

    console.log(CollapseScrollHelper);

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
                var $target = $($(this).data('target'));
                $target
                    .on('show.bs.collapse', function () {
                        CollapseScrollHelper.startCollapse($target);
                    })
                    .on('shown.bs.collapse', function () {
                        CollapseScrollHelper.stopCollapse();
                    });
            }
        });
    };

    $.fn.ToggleAction = ToggleAction;
});