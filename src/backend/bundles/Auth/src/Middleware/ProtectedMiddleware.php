<?php
namespace Auth\Middleware;

use Common\REST\GenericRESTResponseBuilder;
use Auth\Middleware\AuthStrategy\HeaderStrategy;
use Auth\Middleware\AuthStrategy\JSONBodyStrategy;
use Auth\Middleware\AuthStrategy\SessionStrategy;
use Auth\Service\CurrentProfileService;
use Auth\Service\NotAuthenticatedException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProtectedMiddleware implements MiddlewareInterface
{
    /** @var CurrentProfileService */
    private $currentProfileService;

    /** @var string */
    private $prefix;

    public function __construct(CurrentProfileService $currentProfileService, string $prefix)
    {
        $this->currentProfileService = $currentProfileService;
        $this->prefix = $prefix;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $isURLProtected = strpos($request->getUri()->getPath(), "{$this->prefix}/protected/") === 0;

        try {
            if($isURLProtected) {
                $this->currentProfileService->attempt([
                    new HeaderStrategy($request),
                    new JSONBodyStrategy($request),
                    new SessionStrategy($request)
                ]);
            }

            return $out($request, $response);
        }catch(NotAuthenticatedException $e) {
            $responseBuilder = new GenericRESTResponseBuilder($response);

            return $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
                ->build()
            ;
        }
    }
}