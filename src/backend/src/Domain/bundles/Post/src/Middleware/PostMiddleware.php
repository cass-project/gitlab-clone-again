<?php
namespace Domain\Post\Middleware;

use CASS\Application\Service\CommandService;
use Domain\Auth\Service\CurrentAccountService;
use CASS\Application\REST\Response\GenericResponseBuilder;
use Domain\Collection\Exception\CollectionNotFoundException;
use Domain\Post\Exception\PostNotFoundException;
use Domain\Post\Middleware\Command\Command;
use Domain\Post\Middleware\Command\CreateCommand;
use Domain\Post\Middleware\Command\DeleteCommand;
use Domain\Post\Middleware\Command\EditCommand;
use Domain\Post\Middleware\Command\GetCommand;
use Domain\Post\Service\PostService;
use Domain\Profile\Exception\ProfileNotFoundException;
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
        $responseBuilder = new GenericResponseBuilder($response);

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