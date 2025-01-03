<?php

use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;
use Tssf\Communityobedience\TwigFileExists;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/vendor/autoload.php';

/**
 * The main function that loads the translations, and calls the twig template to build the output
 *
 * @throws LoaderError
 * @throws RuntimeError
 * @throws SyntaxError
 */
function index(): void
{
    $loader = new FilesystemLoader('./templates');
    $twig = new Environment($loader);
    // See https://localise.biz/whiteitsolutions/community-obedience for translation tool
    $translator = new Translator('en');
    $translator->addLoader('xliff', new XliffFileLoader());
    // Load each translation xliff file here, set the locale that it'll refer to in the below array
    $translator->addResource('xliff', './translations/community-obedience-en-AU.xlf', 'en');
    $translator->addResource('xliff', './translations/community-obedience-ko.xlf', 'ko');
    $translator->addResource('xliff', './translations/community-obedience-ta.xlf', 'ta');
    $translator->addResource('xliff', './translations/community-obedience-zh-cn.xlf', 'zh-cn');
    $translator->addResource('xliff', './translations/community-obedience-zh-hk.xlf', 'zh-hk');
    $translator->setFallbackLocales(['en']);

    $twig->addExtension(new TranslationExtension($translator));
    $twig->addExtension(new TwigFileExists());

    /**
     * Load each translation into the array here. The key for the array should be locale as set above.
     * Each array member should be an array that has a name key (for the name displayed on the buttons) and a
     * dateLocale key (See https://momentjs.com/ for possible Locales)
     */
    $translations = [
        'en' => [
            'name' => 'English',
            'dateLocale' => 'en'
        ],
        'ko' => [
            'name' => 'Korean',
            'dateLocale' => 'ko'
        ],
        'ta' => [
            'name' => 'Tamil',
            'dateLocale' => 'ta_LK'
        ],
        'zh-cn' => [
            'name' => 'Chinese (Simplified)',
            'dateLocale' => 'zh-cn'
        ],
        'zh-hk' => [
            'name' => 'Chinese (Traditional)',
            'dateLocale' => 'zh-hk'
        ],
    ];

    // Extract the dateLocale keys for the JS rendering
    $dateLocaleKeys = [];
    foreach ($translations as $locale => $translation) {
        $dateLocaleKeys[$locale] = $translation['dateLocale'];
    }

    echo $twig->render('main.html.twig', [
        'translations' => $translations,
        'dateLocaleKeys' => $dateLocaleKeys,
        'lastUpdated' => filemtime('cache.appcache'),
        'dailyPrayersMembers' => getDailyPrayersMembersAll(),
    ]);
}

/**
 * Gets all the members per day for prayer
 */
function getDailyPrayersMembersAll(): array
{
    $dailyTemplateVars = [];
    for ($day = 1; $day <= 31; $day++) {
        $dailyTemplateVars[$day] = getDailyPrayersMembers($day);
    }

    return $dailyTemplateVars;
}

/**
 * Gets the members for prayer for a single day
 */
function getDailyPrayersMembers(int $day): array
{
    // Lookup names for deceased and living members we are praying for
    $templateVars = [];
    foreach (range(1, 3) as $region) {
        $filename = __DIR__ . "/common/{$day}_living_members_{$region}.txt";
        if (file_exists($filename)) {
            $templateVars["living_members_{$region}"] = trim(file_get_contents($filename));
        }
    }
    $deceasedMembersFilename = __DIR__ . "/common/{$day}_deceased_members.txt";
    if (file_exists($deceasedMembersFilename)) {
        $templateVars['deceased_members'] = trim(file_get_contents($deceasedMembersFilename));
    }

    return $templateVars;
}

index();