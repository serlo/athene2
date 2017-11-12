/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author  Julian Kempff (julian.kempff@serlo.org)
 * @license LGPL-3.0
 * @license http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
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