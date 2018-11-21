var codeprepare = function(converter) {
  return [
    {
      type: 'lang',
      filter: (function() {
        var replacements = {},
          replacementRegexp = '',
          codeRegexp = /(?:^|\n)```(.*)\n([\s\S]*?)\n```/gm,
          charsToDecode = ['~D', '%', '\\|', '/'],
          i,
          l

        for (i = 0, l = charsToDecode.length; i < l; i++) {
          // replacementRegexp += '\\' + charsToDecode[i];
          // charsToDecode[i] = '\\' + charsToDecode[i];
          replacements[charsToDecode[i].replace(/\\/g, '')] = '§SC' + i
        }

        // (~D|\$|/|%)
        // (~D|%|\||\/)/gm
        replacementRegexp = new RegExp(
          '(' + charsToDecode.join('|') + ')',
          'gm'
        )

        function replace(whole, language, code) {
          // escape all chars in code
          code = code.replace(replacementRegexp, function(match) {
            return replacements[match] || match
          })

          return '\n```' + language + '\n' + code + '\n```'
        }

        return function(text) {
          return text.replace(codeRegexp, replace)
        }
      })()
    }
  ]
}

module.exports = codeprepare
