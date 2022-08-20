<?php

use languages\en\english;
use languages\ko\ko;
use languages\zh\zh;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

$loader = new FilesystemLoader('./templates');
$twig = new Environment($loader);
$translator = new \Symfony\Component\Translation\Translator('en');
$translator->addLoader('xliff', new \Symfony\Component\Translation\Loader\XliffFileLoader());
$translator->addResource('xliff', './translations/community-obedience-en-AU.xlf', 'en');
$translator->addResource('xliff', './translations/community-obedience-zh.xlf', 'zh');
$translator->addResource('xliff', './translations/community-obedience-ko.xlf', 'ko');
$translator->setFallbackLocales(['en']);

$twig->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension($translator));


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