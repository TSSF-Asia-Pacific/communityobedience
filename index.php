<?php

use languages\en\english;
use languages\ko\ko;
use languages\zh\zh;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

$loader = new FilesystemLoader('./templates');
$twig = new Environment($loader);

    // Load each translation into the translations array here
    $translations['en'] = new english();
    $translations['ko'] = new ko();
    $translations['zh'] = new zh();

    $dateLocaleKeys = [];
    foreach($translations as $locale => $translation) {
        $dateLocaleKeys[$locale] = $translation->dateLocale;
    }

    echo $twig->render('main.html.twig', [
        'translations' => $translations,
        'dateLocaleKeys' => $dateLocaleKeys,
        'lastUpdated' => filemtime('cache.appcache'),
    ]);