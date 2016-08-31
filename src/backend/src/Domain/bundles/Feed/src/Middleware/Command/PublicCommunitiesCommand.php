<?php
namespace Domain\Feed\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PublicCommunitiesCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $source = $this->sourceFactory->getPublicCommunitiesSource();

        return $this->makeFeed($source, $request, $responseBuilder);
    }
}