/*global define*/
define(['jquery'], function ($) {
    "use strict";
    var SingleChoice;

    SingleChoice = function () {
        return $(this).each(function () {
            var $self = $(this);
            $self.submit(function (e) {
                e.preventDefault();
                var $selected = $('.single-choice-answer-choice:checked', this),
                    $feedback = $selected.siblings('.single-choice-answer-feedback');

                $('.single-choice-answer-feedback', $self).hide();
                $feedback.show();
                return false;
            });
        });
    };

    $.fn.SingleChoice = SingleChoice;
});
