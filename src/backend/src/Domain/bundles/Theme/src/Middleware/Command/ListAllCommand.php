<?php
namespace CASS\Domain\Bundles\Theme\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListAllCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $themes = $this->themeService->getAllThemes();

        $responseBuilder
            ->setJson([
                'total' => count($themes),
                'entities' => array_map(function(Theme $theme) {
                    return $theme->toJSON();
                }, $themes)
            ])
            ->setStatusSuccess();

        return $responseBuilder->build();
    }
}