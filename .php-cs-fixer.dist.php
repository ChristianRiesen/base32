<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->exclude('vendor')
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        '@PSR1' => true,
        'concat_space' => ['spacing' => 'none'],
        'declare_strict_types' => true,
        'logical_operators' => true,
        'native_function_casing' => true,
        'native_function_invocation' => ['include' => ['@all'], 'scope' => 'all', 'strict' => true],
        'native_function_type_declaration_casing' => true,
        'no_alternative_syntax' => true,
        'no_leading_namespace_whitespace' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unused_imports' => true,
        'no_whitespace_before_comma_in_array' => true,
        'yoda_style' => true,
    ])
    ->setFinder($finder)
;
