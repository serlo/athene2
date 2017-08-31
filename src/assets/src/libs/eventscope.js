/**
 *
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author  Julian Kempff (julian.kempff@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
import _ from 'underscore';

function eventScope(element) {
  var Events = {},
    fn = {};

  fn.addEventListener = function(type, fn) {
    Events[type] = Events[type] || [];
    Events[type].push(fn);
    return true;
  };

  fn.removeEventListener = function(type, fn) {
    return (
      !Events[type] ||
      (function() {
        if (fn === undefined) {
          delete Events[type];
          return true;
        }

        _.each(Events[type], function(i) {
          if (Events[type][i] === fn) {
            Events[type].splice(i, 1);
            return false;
          }
        });
      })()
    );
  };

  fn.trigger = function(type) {
    var self = this,
      slice = Array.prototype.slice.bind(arguments);

    if (!Events.hasOwnProperty(type)) {
      return true;
    }

    _.each(Events[type], function(fn) {
      fn.apply(self, slice(1));
    });
  };

  switch (element.constructor.name) {
    case 'Function':
      _.extend(element.prototype, fn);
      break;
    default:
      _.extend(element, fn);
  }
}

export default element => {
  eventScope(element);
};
