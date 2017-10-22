/**
 *
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author  Julian Kempff (julian.kempff@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */

import _ from 'underscore'

/* global define */
var initializers = []

function addInitializer (fn) {
  initializers.push(fn)
}

function initializeContextual ($context) {
  _.each(initializers, function (init) {
    init($context)
  })
}

const Content = {
  init: function ($context) {
    initializeContextual($context)
  },
  add: function (fn) {
    addInitializer(fn)
  }
}

export default Content
