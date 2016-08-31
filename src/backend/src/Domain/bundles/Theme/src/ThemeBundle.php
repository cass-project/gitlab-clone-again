<?php
namespace Domain\Theme;

use CASS\Application\Frontline\FrontlineBundleInjectable;
use CASS\Application\Bundle\GenericBundle;
use Domain\Theme\Frontline\ThemeScript;

class ThemeBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            ThemeScript::class
        ];
    }
}