<?php
namespace CASS\Domain\Bundles\Post\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Post\Exception\PostNotFoundException;
use CASS\Domain\Bundles\Post\Middleware\Command\CreateCommand;
use CASS\Domain\Bundles\Post\Middleware\Command\DeleteCommand;
use CASS\Domain\Bundles\Post\Middleware\Command\EditCommand;
use CASS\Domain\Bundles\Post\Middleware\Command\GetCommand;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;
    
    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null) 
    {
        $responseBuilder = new CASSResponseBuilder($response);

        try {
            $resolver = $this->commandService->createResolverBuilder()
                ->attachDirect('create', CreateCommand::class)
                ->attachDirect('delete', DeleteCommand::class)
                ->attachDirect('edit', EditCommand::class)
                ->attachDirect('get', GetCommand::class)
                ->resolve($request);

            return $resolver->run($request, $responseBuilder);
        }
        catch(CollectionNotFoundException $e){
            $responseBuilder
              ->setStatusNotFound()
              ->setError($e);
        }
        catch(ProfileNotFoundException $e){
            $responseBuilder
              ->setStatusNotFound()
              ->setError($e);
        }
        catch(PostNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}