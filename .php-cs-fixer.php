<?php

/*
 * This file is part of PHP CS Fixer.
 */

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
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
