/*global define, window*/
define(['jquery', 'underscore', 'system_notification', 'translator'], function ($, _, SystemNotification, t) {
    "use strict";
    var checkSupportFor = [
            'JSON',
            'localStorage'
        ],
        fails = [];

    function check() {
        if ($('html').hasClass('old-ie')) {
            SystemNotification.notify(t('You are using an outdated web browser. Please consider an update!'), 'danger');
        }
        // check for browser support
        _.each(checkSupportFor, function (value) {
            if (!window[value]) {
                fails.push('<strong>' + value + '</strong>');
            }
        });

        if (fails.length) {
            SystemNotification.notify(t('Your browser doesnt support the following technologies: %s <br>Please update your browser!', fails.join(', ')), 'warning', true);
        }

        return fails;
    }

    return {
        check: check
    };
});