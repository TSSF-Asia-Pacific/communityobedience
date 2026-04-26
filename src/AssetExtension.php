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
            $this->manifest =
                json_decode(file_get_contents($manifestPath), true) ?? [];
        }
    }

    public function getFunctions(): array
    {
        return [new TwigFunction("asset", [$this, "getAsset"])];
    }

    public function getAsset(string $path): string
    {
        $basePath = getenv("APP_BASE_PATH") ?: "/";

        // Remove leading slash for manifest lookup
        $lookup = ltrim($path, "/");
        $resolvedPath = isset($this->manifest[$lookup])
            ? $this->manifest[$lookup]
            : $path;

        return rtrim($basePath, "/") . "/" . ltrim($resolvedPath, "/");
    }
}
