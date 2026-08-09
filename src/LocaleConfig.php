<?php

declare(strict_types=1);

namespace Tssf\Communityobedience;

use RuntimeException;

/**
 * Loads the locale configuration, the single source of truth shared with
 * app/index.ts and translations/download.sh
 */
class LocaleConfig
{
    private array $locales;

    public function __construct(string $configPath)
    {
        $json = file_get_contents($configPath);
        if ($json === false) {
            throw new RuntimeException("Unable to read {$configPath}");
        }

        $this->locales = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    public function all(): array
    {
        return $this->locales;
    }
}
