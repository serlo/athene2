# Server Crontabs

* * * * * su - www-data -c '(cd /var/www/athene2.serlo.org/athene2/src/public; php index.php notification worker)'
* 05 * * * su - www-data -c '(cd /var/www/athene2.serlo.org/athene2/src/public; php index.php session gc)'

# Converting phtml to twig (Careful, buggy!)

1. Echo
 1. `\<\?php\s*echo (.*);\s*\?>`
 2. `{{ $1 }}`
2. If
 1. `\<\?php\s*if\s*\((.*)\)\:\s*\?\>`
 2. `{% if $1 %}`
 3. `\<\?php\s*endif;\s*\?\>`
 4. `{% endif %}`
3. Foreach
 1. `\<\?php\s*foreach\s*\((.*)\s*as\s*(.*)\)\:\s*\?\>`
 2. `{% for $2 in $1 %}`
 3. `\<\?php\s*endforeach;\s*\?\>`
 4. `{% endfor %}`
4. This
 1. `\$this\-\>`
 2. ``
5. ->
 1. `\-\>`
 2. `.`
6. $
 1. `\$([a-zA-Z0-9]+)`
 2. `$1`
7. array
 1. `array\(([a-zA-Z\'\=\>\(\)\-]+)\)`
 2. `{ $1 }`
9. array =>
 1. `\=\>`
 2. `:`
8. translate
 1. `translate\((.*)\)`
 2. `$1 | trans`

# Run POEdit on mac

`WXTRACE=poedit,poedit.tmp,poedit.execute /Applications/Poedit.app/Contents/MacOS/Poedit --verbose --keep-temp-files`