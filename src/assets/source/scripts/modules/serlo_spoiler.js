/*global define*/
define(['jquery'], function ($) {
    "use strict";
    var Spoiler;

    Spoiler = function () {
        return $(this).each(function () {
            $('> .spoiler-teaser', this)
                .unbind('click')
                .first()
                .click(function (e) {
                    var glyphicon = $(this).find('.glyphicon-regular');
                    e.preventDefault();
                    $(this).next('.spoiler-content').slideToggle();
                    glyphicon.toggleClass('glyphicon-expand');
                    glyphicon.toggleClass('glyphicon-collapse-top');
                    return;
                });
        });
    };

    $.fn.Spoiler = Spoiler;
});