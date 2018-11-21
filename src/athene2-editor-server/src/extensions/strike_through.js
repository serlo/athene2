var strikethrough = function(converter) {
  return [
    {
      // strike-through
      // NOTE: showdown already replaced "~" with "~T", so we need to adjust accordingly.
      type: 'lang',
      regex: '(~T){2}([^~]+)(~T){2}',
      replace: function(match, prefix, content, suffix) {
        return '<del>' + content + '</del>'
      }
    }
  ]
}

module.exports = strikethrough
