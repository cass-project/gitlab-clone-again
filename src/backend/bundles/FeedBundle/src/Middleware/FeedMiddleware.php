<?php
namespace Feed\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Sphinx\SphinxClient;
use Zend\Stratigility\MiddlewareInterface;
use Feed\Middleware\Command\Command;

class FeedMiddleware implements MiddlewareInterface
{
    private $sphinxService;
    public function __construct(SphinxClient $sphinxService)
    {
        $this->sphinxService = $sphinxService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);
        $command = Command::factory($request);
        $command->setSphinxService($this->sphinxService);
        return $responseBuilder
            ->setStatusSuccess()
            ->setJson($command->run($request))
            ->build()
        ;
    }
}