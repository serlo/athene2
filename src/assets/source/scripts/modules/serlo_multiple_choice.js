/*global define*/
define(['jquery'], function ($) {
    "use strict";
    var MultipleChoice;

    MultipleChoice = function () {
        return $(this).each(function () {
            var $group = $(this);
            $group.submit(function (e) {
                e.preventDefault();
                var mistakes = 0,
                    feedback = [],
                    $feedbackFailure = $('.multiple-choice-group-failure', $group),
                    $feedbackSuccess = $('.multiple-choice-group-success', $group);

                $('.multiple-choice-wrong-answer-feedback', $group).hide();

                $('.multiple-choice-answer-choice', this).each(function (k, v) {
                    var $input = $(v),
                        answer = Boolean($input.is(':checked')),
                        correct = Boolean($input.val()),
                        $feedback;

                    if (correct && answer) {
                        if ($input.data().feedback) {
                            feedback.push($input.data().feedback);
                        }
                    }

                    if (correct && !answer) {
                        // correct solution not marked as correct
                        mistakes++;
                    } else if (!correct && answer) {
                        // wrong solution marked wrongfully
                        $feedback = $input.siblings('.multiple-choice-wrong-answer-feedback');
                        $feedback.show();
                        mistakes++;
                    }
                });

                $feedbackFailure.hide();
                $feedbackSuccess.hide();
                if (mistakes === 0) {
                    if (feedback > 0) {
                        $feedbackSuccess.html('<p>' + feedback.join('</p><p>') + '</p>');
                    }
                    $feedbackSuccess.show();
                } else {
                    $feedbackFailure.show();
                }
                return false;
            });
        });
    };

    $.fn.MultipleChoice = MultipleChoice;
});
