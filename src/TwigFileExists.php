<?php

declare(strict_types=1);

namespace Tssf\Communityobedience;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Check if a file exists in the template director
 */
class TwigFileExists extends AbstractExtension
{
    #[\Override]
    public function getFunctions(): array
    {
        return [
            'file_exists' => new TwigFunction('file_exists', fn($filename): bool => file_exists(__DIR__ . '/../templates/' . $filename))
        ];
    }
}
