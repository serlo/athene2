<?php

var_dump(__DIR__);

$finder = PhpCsFixer\Finder::create()
    ->notPath('src/vendor')
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        'method_chaining_indentation' => true,
        'no_trailing_comma_in_list_call' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_whitespace_in_blank_line' => true,
        'trailing_comma_in_multiline_array' => true,
    ])
    ->setFinder($finder);
