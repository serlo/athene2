#!/bin/sh
for D in "../src/module/"*
do
    rm "${D}/autoload_classmap.php" 2>/dev/null
    rm "${D}/template_map.php" 2>/dev/null
done