<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withRootFiles()
    ->withPhpSets()
    ->withPreparedSets(deadCode: true, codeQuality: true, twig: true)
    ->withTypeCoverageLevel(9);
