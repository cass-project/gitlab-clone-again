<?php
namespace Domain\Community\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Community\Middleware\Request\CreateCommunityRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $createCommunityRequest = new CreateCommunityRequest($request);

        $community = $this->communityService->createCommunity($createCommunityRequest->getParameters());

        return $responseBuilder->setStatusSuccess()->setJson([
            'entity' => $community->toJSON()
        ])->build();
    }
}