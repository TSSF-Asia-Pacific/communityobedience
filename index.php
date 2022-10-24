<?php

use languages\en\english;
use languages\ko\ko;
use languages\zh\zh;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

$loader = new FilesystemLoader('./templates');
$twig = new Environment($loader);
// See https://localise.biz/whiteitsolutions/community-obedience for translation tool
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
        'dailyPrayersMembers' => getDailyPrayersMembersAll(),
    ]);


function getDailyPrayersMembersAll(){
    $dailyTemplateVars = [];
    for ($day = 1; $day <= 31; $day++) {
        $dailyTemplateVars[$day] = getDailyPrayersMembers($day);
    }

    return $dailyTemplateVars;
}


function getDailyPrayersMembers($day) {
    // Lookup names for deceased and living members we are praying for
    $templateVars = [];
    foreach(range(1,3) as $region) {
        $filename = __DIR__ . "/common/${day}_living_members_${region}.txt";
        if (file_exists($filename)) {
            $templateVars["living_members_${region}"] = file_get_contents($filename);
        }
    }
    $deceasedMembersFilename = __DIR__ . "/common/${day}_deceased_members.txt";
    if (file_exists($deceasedMembersFilename)) {
        $templateVars['deceased_members'] = file_get_contents($deceasedMembersFilename);
    }

    return $templateVars;
}