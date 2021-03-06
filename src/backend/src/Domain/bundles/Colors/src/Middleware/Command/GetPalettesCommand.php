<?php
namespace CASS\Domain\Bundles\Colors\Middleware\Command;

use CASS\Application\Command\Command;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Colors\Entity\Palette;
use CASS\Domain\Bundles\Colors\Service\ColorsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetPalettesCommand implements Command
{
    /** @var ColorsService */
    private $colorsService;

    public function __construct(ColorsService $colorsService) {
        $this->colorsService = $colorsService;
    }

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
        return $responseBuilder
            ->setJson([
                'palettes' => array_map(function(Palette $palette) {
                    return $palette->toJSON();
                }, $this->colorsService->getPalettes())
            ])
            ->setStatusSuccess()
            ->build();
    }
}