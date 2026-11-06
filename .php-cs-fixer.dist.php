<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/public',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        // Base PSR-12 ruleset
        '@PSR12'                        => true,

        // Enforce strict_types on every file
        'declare_strict_types'          => true,

        // Modern array syntax
        'array_syntax'                  => ['syntax' => 'short'],

        // Import hygiene
        'no_unused_imports'             => true,
        'ordered_imports'               => ['sort_algorithm' => 'alpha'],
        'single_import_per_statement'   => true,

        // Trailing commas in multi-line structures
        'trailing_comma_in_multiline'   => ['elements' => ['arrays', 'arguments', 'parameters']],

        // String & concatenation
        'no_trailing_whitespace'        => true,
        'concat_space'                  => ['spacing' => 'one'],
    ])
    ->setFinder($finder);
