<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
  ->in([
    __DIR__ . '/app',
    __DIR__ . '/database',
    __DIR__ . '/routes',
    __DIR__ . '/tests',
  ])
  ->name('*.php')
  ->exclude(['storage', 'bootstrap/cache'])
  ->ignoreDotFiles(true)
  ->ignoreVCS(true);

return (new Config())
  ->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => ['default' => 'single_space'],
    'blank_line_before_statement' => [
      'statements' => ['return', 'if', 'for', 'foreach', 'while', 'switch'],
    ],
    'no_unused_imports' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'phpdoc_align' => ['align' => 'vertical'],
    'phpdoc_order' => true,
    'single_quote' => true,
    'trailing_comma_in_multiline' => true,
  ])
  ->setFinder($finder)
  ->setUsingCache(true)
  ->setRiskyAllowed(true)
  ->setIndent('    ')
  ->setLineEnding("\n");
