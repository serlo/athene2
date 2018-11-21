/**
 * Serlo Flavored Markdown
 * Spoilers:
 * Transforms ///.../// blocks into spoilers
 **/
var spoiler = function(converter) {
  var filter,
    findSpoilers = new RegExp(/^<p>=,sp. (.*)<\/p>([\s\S]*?)<p>=,sp.<\/p>/gm)

  filter = function(text) {
    return text.replace(findSpoilers, function(original, title, content) {
      return (
        '<div class="spoiler panel panel-default"><div class="spoiler-teaser panel-heading"><span class="fa fa-caret-square-o-down"></span>' +
        title +
        '</div><div class="spoiler-content panel-body">' +
        content +
        '</div></div>'
      )
    })
  }

  return [
    {
      type: 'output',
      filter: filter
    }
  ]
}

module.exports = spoiler
