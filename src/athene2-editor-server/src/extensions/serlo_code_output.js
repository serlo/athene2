var codeoutput = function(converter) {
  return [
    {
      type: 'lang',
      filter: (function() {
        var charsToEncode = ['~D', '%', '|', '/'],
          replacements = {},
          regexp,
          i,
          l

        for (i = 0, l = charsToEncode.length; i < l; i++) {
          replacements['' + i] = charsToEncode[i]
        }

        regexp = new RegExp('§SC([0-9])', 'gm')

        function replace(whole, match) {
          return replacements[parseInt(match)] || match
        }

        return function(text) {
          return text.replace(regexp, replace)
        }
      })()
    }
  ]
}

module.exports = codeoutput
