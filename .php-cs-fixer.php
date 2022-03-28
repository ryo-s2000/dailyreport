<?php

/*
 * This file is part of PHP CS Fixer.
 */

$finder = PhpCsFixer\Finder::create()
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true)
    ->exclude('tests/Fixtures')
    ->in(__DIR__)
    ->append([
        __DIR__.'/dev-tools/doc.php'
    ])
;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP74Migration' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'modernize_strpos' => true,
    ])
    ->setFinder($finder)
;

return $config;
