/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author  Julian Kempff (julian.kempff@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */

/*global define*/
define(['underscore'], function (_) {
    "use strict";
    var initializers = [];


    function addInitializer(fn) {
        initializers.push(fn);
    }

    function initializeContextual($context) {
        _.each(initializers, function (init) {
            init($context);
        });
    }

    return {
        init: function ($context) {
            initializeContextual($context);
        },
        add: function (fn) {
            addInitializer(fn);
        }
    };
});