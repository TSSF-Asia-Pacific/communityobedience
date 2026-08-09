<?php

use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;
use Tssf\Communityobedience\AssetExtension;
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

    $translations = [];
    foreach (getLocaleConfig() as $locale => $localeConfig) {
        $translator->addResource('xliff', __DIR__ . "/translations/{$localeConfig['xlfFile']}", $locale);
        $translations[$locale] = [
            'name' => $localeConfig['name'],
        ];
    }
    $translator->setFallbackLocales(['en']);

    $twig->addExtension(new TranslationExtension($translator));
    $twig->addExtension(new TwigFileExists());
    $twig->addExtension(new AssetExtension(__DIR__ . '/dist/manifest.json'));

    echo $twig->render('main.html.twig', [
        'translations' => $translations,
        'lastUpdated' => new DateTime(),
        'dailyPrayersMembers' => getDailyPrayersMembersAll(),
    ]);
}

/**
 * Loads the locale configuration from translations/locales.json, the single source of truth
 * that is also consumed by app/index.ts and translations/download.sh
 */
function getLocaleConfig(): array
{
    $json = file_get_contents(__DIR__ . '/translations/locales.json');
    if ($json === false) {
        throw new RuntimeException('Unable to read translations/locales.json');
    }

    return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
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
