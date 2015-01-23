/*global define*/
define(['jquery'], function ($) {
    "use strict";
    var TriggerAction;

    TriggerAction = function () {
        return $(this).each(function () {
            // Edit mode toggle
            if ($(this).data('trigger') === 'ping') {
                $(this)
                    .click(function () {
                        var $that = $(this),
                            location = $that.data('href');
                        if (location) {
                            $.ajax({
                                url: location
                            });
                        }
                    });
            }
        });
    };

    $.fn.TriggerAction = TriggerAction;
});