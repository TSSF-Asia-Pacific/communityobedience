<?php

// autoloader
use languages\AbstractLanguage;
use languages\en\english;
use languages\ko\ko;
use languages\zh\zh;

require 'vendor/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader('./templates');
$twig = new \Twig\Environment($loader);

    // Load each translation into the translations array here
    $translations['en'] = new english();
    // $translations['ko'] = new ko();
    $translations['zh'] = new zh();

    $dateLocaleKeys = [
            'en' => $translations['en']->dateLocale,
            'zh' => $translations['zh']->dateLocale,
    ];

    echo $twig->render('main.html.twig', [
        'translations' => $translations,
        'dateLocaleKeys' => $dateLocaleKeys,
        'lastUpdated' => filemtime('cache.appcache'),
    ]);