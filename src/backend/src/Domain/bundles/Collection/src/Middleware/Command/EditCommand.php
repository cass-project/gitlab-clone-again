<?php
namespace Domain\Collection\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Collection\Middleware\Request\EditCollectionRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EditCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $collectionId = $request->getAttribute('collectionId');
        $parameters = (new EditCollectionRequest($request))->getParameters();

        $collection = $this->collectionService->editCollection($collectionId, $parameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $collection->toJSON()
            ])
            ->build();
    }
}