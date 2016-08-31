<?php
namespace Domain\Auth\Middleware;

use CASS\Application\REST\Response\GenericResponseBuilder;
use Domain\Auth\Middleware\AuthStrategy\HeaderStrategy;
use Domain\Auth\Middleware\AuthStrategy\JSONBodyStrategy;
use Domain\Auth\Middleware\AuthStrategy\SessionStrategy;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Auth\Exception\NotAuthenticatedException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProtectedMiddleware implements MiddlewareInterface
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(CurrentAccountService $currentAccountService)
    {
        $this->currentAccountService = $currentAccountService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $isURLProtected = strpos($request->getUri()->getPath(), "/protected/") === 0;

        try {
            $this->currentAccountService->signInWithStrategies([
                new HeaderStrategy($request),
                new JSONBodyStrategy($request),
                new SessionStrategy($request)
            ]);
        }catch(NotAuthenticatedException $e) {
            if($isURLProtected) {
                $responseBuilder = new GenericResponseBuilder($response);

                return $responseBuilder
                    ->setStatusNotAllowed()
                    ->setError($e)
                    ->build()
                ;
            }
        }

        return $out($request, $response);
    }
}