<?php

use PhpCsFixer\Config;
use Symfony\Component\Finder\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->exclude(['bootstrap', 'node_modules', 'storage', 'vendor']);

$config = new Config();

return
    $config->setCacheFile(__DIR__ . '/.php_cs.cache')
        ->setRules([
            '@PhpCsFixer' => true,
            'concat_space' => ['spacing' => 'one'],
            'multiline_whitespace_before_semicolons' => false,
            'not_operator_with_successor_space' => true,
            'php_unit_internal_class' => false,
            'php_unit_method_casing' => false,
            'php_unit_test_class_requires_covers' => false,
            'yoda_style' => false,
        ])
        ->setFinder($finder);
