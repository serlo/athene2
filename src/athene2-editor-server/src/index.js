var dnode = require('dnode'),
  Showdown = require('showdown'),
  converter,
  server,
  port = 7070

converter = new Showdown.Converter({
  extensions: [
    require('./extensions/serlo_code_prepare'),
    require('./extensions/injections'),
    require('./extensions/at_username'),
    require('./extensions/strike_through'),
    require('./extensions/table'),
    require('./extensions/spoiler_prepare'),
    require('./extensions/spoiler'),
    require('./extensions/html_strip'),
    require('./extensions/latex'),
    require('./extensions/latex_output'),
    require('./extensions/serlo_code_output')
  ]
})

// converter.config.math = true;
// converter.config.stripHTML = true;

// **render**
// @param {String} input Json string,
// containing Serlo Flavored Markdown (sfm)
// structured for layout.
// @param {Function} callback
function render(input, callback) {
  var output,
    data,
    row,
    column,
    i,
    l,
    j,
    lj,
    mjt = { timeout: null }

  // callback(output, Exception, ErrorMessage);
  if (input === undefined) {
    callback('', 'InvalidArgumentException', 'No input given')
    return
  }

  if (input === '') {
    callback('')
  } else {
    // parse input to object
    try {
      input = input.trim().replace(/&quot;/g, '"')
      data = JSON.parse(input)
    } catch (e) {
      callback(
        '',
        'InvalidArgumentException',
        'No valid json string given: ' + input
      )
      return
    }

    output = ''

    for (i = 0, l = data.length; i < l; i++) {
      row = data[i]
      output += '<div class="r">'
      for (j = 0, lj = row.length; j < lj; j++) {
        column = row[j]
        output += '<div class="c' + column.col + '">'
        output += converter.makeHtml(column.content)
        output += '</div>'
      }
      output += '</div>'
    }

    callback(output)
  }
}

server = dnode(function() {
  this.render = render
})

server.listen(port)
