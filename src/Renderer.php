<?php

declare(strict_types=1);

namespace Tssf\Communityobedience;

use DateTime;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Builds the Twig environment and renders the static site
 */
class Renderer
{
    public function __construct(
        private readonly string $projectDir,
        private readonly LocaleConfig $localeConfig,
        private readonly DailyPrayers $dailyPrayers,
    ) {
    }

    public function render(): string
    {
        $translations = [];
        foreach ($this->localeConfig->all() as $locale => $localeConfig) {
            $translations[$locale] = [
                'name' => $localeConfig['name'],
            ];
        }

        return $this->createTwig()->render('main.html.twig', [
            'translations' => $translations,
            'lastUpdated' => new DateTime(),
            'dailyPrayersMembers' => $this->dailyPrayers->getMembersForAllDays(),
        ]);
    }

    private function createTwig(): Environment
    {
        $twig = new Environment(new FilesystemLoader("{$this->projectDir}/templates"));
        $twig->addExtension(new TranslationExtension($this->createTranslator()));
        $twig->addExtension(new TwigFileExists());
        $twig->addExtension(new AssetExtension("{$this->projectDir}/dist/manifest.json"));

        return $twig;
    }

    private function createTranslator(): Translator
    {
        // See https://localise.biz/whiteitsolutions/community-obedience for translation tool
        $translator = new Translator('en');
        $translator->addLoader('xliff', new XliffFileLoader());
        foreach ($this->localeConfig->all() as $locale => $localeConfig) {
            $translator->addResource('xliff', "{$this->projectDir}/translations/{$localeConfig['xlfFile']}", $locale);
        }
        $translator->setFallbackLocales(['en']);

        return $translator;
    }
}
