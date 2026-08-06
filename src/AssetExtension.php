<?php

namespace Tssf\Communityobedience;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssetExtension
{
    private array $manifest = [];

    public function __construct(string $manifestPath)
    {
        if (file_exists($manifestPath)) {
            $this->manifest = json_decode(file_get_contents($manifestPath), true) ?? [];
        }
    }

    #[\Twig\Attribute\AsTwigFunction(name: 'asset')]
    public function getAsset(string $path): string
    {
        // Remove leading slash for manifest lookup
        $lookup = ltrim($path, '/');

        return $this->manifest[$lookup] ?? $path;
    }
}
