#!/bin/sh

for D in "../src/module/"*
do
    php ../src/vendor/zendframework/zendframework/bin/classmap_generator.php -l "${D}/src" -o "${D}/autoload_classmap.php" -w
done