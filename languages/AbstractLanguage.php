<?php
namespace languages;
/* Extend this abstract class and override the public properties
 * It's probably easier to just copy the English version. This file is more
 * useful for code completion.
 */


use ReflectionClass;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractLanguage
{
    public $name = "Language Name";

    public $dateLocale = "en"; // See https://momentjs.com/ for possible Locales
}