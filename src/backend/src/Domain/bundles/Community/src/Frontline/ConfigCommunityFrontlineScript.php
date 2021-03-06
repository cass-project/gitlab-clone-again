<?php
namespace CASS\Domain\Bundles\Community\Frontline;

use CASS\Application\Bundles\Frontline\FrontlineScript;
use CASS\Domain\Bundles\Community\Scripts\FeaturesListFrontlineScript;

class ConfigCommunityFrontlineScript implements FrontlineScript
{
    public function tags(): array {
        return [
            FrontlineScript::TAG_GLOBAL
        ];
    }

    public function __invoke(): array {
        return [
            'config' => [
                'community' => [
                    'features' => FeaturesListFrontlineScript::class
                ]
            ]
        ];
    }
}