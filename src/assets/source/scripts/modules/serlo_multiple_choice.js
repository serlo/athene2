/*global define*/
define(['jquery'], function ($) {
    "use strict";
    var MultipleChoice;

    MultipleChoice = function () {
        return $(this).each(function () {
            var $self = $(this);
            $self.submit(function (e) {
                e.preventDefault();
                var $selected = $('.multiple-choice-answer-choice:checked', this),
                    $feedback = $selected.siblings('.multiple-choice-answer-feedback');

                $('.multiple-choice-answer-feedback', $self).hide();
                $feedback.show();
                return false;
            });
        });
    };

    $.fn.MultipleChoice = MultipleChoice;
});
