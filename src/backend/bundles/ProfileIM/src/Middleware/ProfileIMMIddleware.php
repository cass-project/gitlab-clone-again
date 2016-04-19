<?php
namespace ProfileIM\Middleware;

use Auth\Service\CurrentAccountService;
use Common\REST\GenericRESTResponseBuilder;
use ProfileIM\Middleware\Command\Command;
use ProfileIM\Service\ProfileIMService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileIMMiddleware implements MiddlewareInterface
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var ProfileIMService */
    private $profileIMService;

    public function __construct(CurrentAccountService $currentAccountService, ProfileIMService $profileIMService)
    {
        $this->currentAccountService = $currentAccountService;
        $this->profileIMService = $profileIMService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        $command = Command::factory($request, $this->currentAccountService, $this->profileIMService);
        $result = $command->run($request);

        if($result === true) {
            $result = [];
        }

        $responseBuilder
            ->setStatusSuccess()
            ->setJson($result);

        return $responseBuilder->build();
    }
}