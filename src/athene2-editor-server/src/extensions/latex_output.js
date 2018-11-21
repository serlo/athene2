var serloSpecificCharsToEncode,
  latexoutput = function() {
    return [
      {
        type: 'output',
        filter: function(text) {
          return encodeSerloSpecificChars(text)
        }
      }
    ]
  }

serloSpecificCharsToEncode = (function() {
  var regexp,
    chars = ['*', '`', '_', '{', '}', '[', ']', '&lt;', '\\'],
    replacements = {},
    l = chars.length,
    i = 0

  for (; i < l; i++) {
    replacements['' + i] = chars[i]
  }

  regexp = new RegExp('§LT([0-9])', 'gm')

  function replace(whole, match) {
    return replacements[parseInt(match)] || match
  }

  return {
    regexp: regexp,
    replace: replace
  }
})()

function encodeSerloSpecificChars(text) {
  return text.replace(
    serloSpecificCharsToEncode.regexp,
    serloSpecificCharsToEncode.replace
  )
}

module.exports = latexoutput
