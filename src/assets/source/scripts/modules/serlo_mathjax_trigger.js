/*global define, MathJax, requestAnimationFrame*/
define(['jquery'], function ($) {
    "use strict";
    var MathjaxTrigger;

    MathjaxTrigger = function () {
        return $(this).on('slide.bs.carousel shown.bs.collapse show.after shown.bs.tab shown.bs.popover shown.bs.modal',
            function () {
                var that = this;
                requestAnimationFrame(function () {
                    var elements = $('.math, .mathInline', that).filter(':visible').toArray();
                    $.each(elements, function (key, element) {
                        MathJax.Hub.Queue(["Typeset", MathJax.Hub, element]);
                    });
                });
            });
    };

    $.fn.MathjaxTrigger = MathjaxTrigger;
});