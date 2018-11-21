var atusername = function() {
  return [
    // @username syntax
    {
      type: 'lang',
      regex: '\\B(\\\\)?@([\\S]+)\\b',
      replace: function(match, leadingSlash, username) {
        // Check if we matched the leading \ and return nothing changed if so
        if (leadingSlash === '\\') {
          return match
        } else {
          return (
            '<a class="user-mention" href="/user/profile/' +
            username +
            '">@' +
            username +
            '</a>'
          )
        }
      }
    },

    // Escaped @'s so we don't get into trouble
    //
    { type: 'lang', regex: '\\\\@', replace: '@' }
  ]
}

module.exports = atusername
