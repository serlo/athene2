/*global define, setInterval*/
define(['jquery', 'moment'], function ($, moment) {
    "use strict";
    var TimeAgo;

    function updateTime($elem, datetime) {
        $elem.text(datetime.fromNow());
    }

    TimeAgo = function () {
        return $(this).each(function () {
            var self = this,
                $self = $(self),
                text = $self.text(),
                datetime = $self.attr('title') || null;

            if (!datetime) {
                return;
            }

            datetime = moment(datetime);

            if (!datetime.isValid()) {
                return;
            }

            $self.attr('title', text);

            updateTime($self, datetime);

            self.interval = setInterval(function () {
                updateTime($self, datetime);
            }, 45000);
        });
    };

    $.fn.TimeAgo = TimeAgo;
});