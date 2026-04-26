<?php

namespace Tssf\Communityobedience;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssetExtension extends AbstractExtension
{
    private array $manifest = [];

    public function __construct(string $manifestPath)
    {
        if (file_exists($manifestPath)) {
            $this->manifest = json_decode(file_get_contents($manifestPath), true) ?? [];
        }
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', [$this, 'getAsset']),
        ];
    }

    public function getAsset(string $path): string
    {
        // Remove leading slash for manifest lookup
        $lookup = ltrim($path, '/');
        if (isset($this->manifest[$lookup])) {
            return $this->manifest[$lookup];
        }

        return $path;
    }
}
