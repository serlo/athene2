/**
 * Serlo Flavored Markdown
 * Spoilers:
 * Transforms ///.../// blocks into spoilers
 **/
var spoilerprepare = function(converter) {
  var filter,
    findSpoilers = new RegExp(/^\/\/\/ (.*)\n([\s\S]*?)(\n|\r)+\/\/\//gm)

  filter = function(text) {
    // convert all "///"s into "=,sp."s
    return text.replace(findSpoilers, function(original, title, content) {
      return '<p>=,sp. ' + title + '</p>\n' + content + '<p>=,sp.</p>'
    })
  }

  return [
    {
      type: 'lang',
      filter: filter
    }
  ]
}

module.exports = spoilerprepare
