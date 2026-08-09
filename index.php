<?php

use Tssf\Communityobedience\DailyPrayers;
use Tssf\Communityobedience\LocaleConfig;
use Tssf\Communityobedience\Renderer;

require __DIR__ . '/vendor/autoload.php';

$renderer = new Renderer(
    __DIR__,
    new LocaleConfig(__DIR__ . '/translations/locales.json'),
    new DailyPrayers(__DIR__ . '/common'),
);

echo $renderer->render();
