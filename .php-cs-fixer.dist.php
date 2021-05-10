<?php

use PhpCsFixer\Config;

$finder = PhpCsFixer\Finder::create()->in(__DIR__);

$rules = [
    '@Symfony' => true,
    'new_with_braces' => true,
    'concat_space' => ['spacing' => 'one'],
    'array_syntax' => ['syntax' => 'short'],
    'yoda_style' => false,
    'phpdoc_no_empty_return' => false,
    'no_superfluous_phpdoc_tags' => false,
    'single_line_throw' => false,
    'array_indentation' => true,
    'declare_strict_types' => true,
    'void_return' => true,
    'non_printable_character' => true,
    'modernize_types_casting' => true,
    'ordered_interfaces' => ['order' => 'alpha', 'direction' => 'ascend'],
    'date_time_immutable' => true,
    'native_constant_invocation' => true,
    'combine_nested_dirname' => true,
    'native_function_invocation' => ['include' => ['@compiler_optimized'], 'scope' => 'namespaced', 'strict' => true],
    'php_unit_construct' => true,
    'php_unit_dedicate_assert' => true,
    'php_unit_expectation' => true,
    'php_unit_internal_class' => true,
    'php_unit_mock_short_will_return' => true,
    'php_unit_strict' => true,
    'strict_comparison' => true,
];

return (new Config())->setRules($rules)->setFinder($finder);
