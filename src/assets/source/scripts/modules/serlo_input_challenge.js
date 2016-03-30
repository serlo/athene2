/*global define*/
define(['jquery', 'string', 'algebrajs'], function ($, S, A) {
    var InputChallenge = function (container) {
        var $container, type, solution, feedback, wrongInputs;

        $container = $(container);

        this.$input = $container.find('.input-challenge-input');
        this.$button = $container.find('.input-challenge-submit');
        this.$feedback = $container.find('.input-challenge-feedback');

        type = this.$input.data('type');
        solution = this.$input.data('solution');
        feedback = this.$input.data('feedback');
        wrongInputs = this.$input.data('wrong-inputs');

        this.inputs = [{
            type: type,
            solution: solution,
            feedback: feedback
        }].concat(wrongInputs);

        this.init();
    };

    InputChallenge.prototype.init = function () {
        var self = this;

        self.$input.focus(function () {
            self.$feedback.hide();
        });

        self.$button.click(function (e) {
            var index, input, isCorrect, feedback;

            e.preventDefault();

            index = self.inputs.findIndex(self.matchesInput.bind(self));
            input = self.inputs[index] || {};

            isCorrect = index === 0;

            feedback = input.feedback || (isCorrect ? 'Right!' : 'Wrong.');

            self.$feedback.html(feedback);
            self.$feedback.addClass('alert alert-' + (isCorrect ? 'success' : 'danger'));
            self.$feedback.removeClass('alert-' + (isCorrect ? 'danger' : 'success'));
            self.$feedback.show();
        });
    };

    InputChallenge.prototype.matchesInput = function (input) {
        var solution = this.normalize(input, input.solution),
            submission = this.normalize(input, this.$input.val());

        switch (input.type) {
        case 'input-expression-equal-match-challenge':
            return solution.subtract(submission).toString() === '0';
        default:
            return solution === submission;
        }
    };

    InputChallenge.prototype.normalize = function (input, string) {
        var normalizeNumber = function (string) {
            return S(string).replaceAll(',', '.').s;
        },
            temp = S(string).collapseWhitespace();

        switch (input.type) {
        case 'input-number-exact-match-challenge':
            return S(normalizeNumber(temp)).replaceAll(' /', '/').replaceAll('/ ', '/').s;
        case 'input-expression-equal-match-challenge':
            return new A.parse(normalizeNumber(temp));
        default:
            return temp.s.toUpperCase();
        }
    };

    $.fn.InputChallenge = function () {
        return $(this).each(function () {
            new InputChallenge(this);
        });
    };
});
