/*global define*/
define(['jquery'], function ($) {
    "use strict";
    var ToggleAction;

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
            }
        });
    };

    $.fn.ToggleAction = ToggleAction;
});