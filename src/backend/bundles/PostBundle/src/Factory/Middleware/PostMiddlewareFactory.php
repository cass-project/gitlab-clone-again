<?php
namespace Post\Factory\Middleware;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Post\Middleware\PostMiddleware;
use Post\Service\PostService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostMiddlewareFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL){
		$postService = $container->get(PostService::class);

		return new PostMiddleware($postService);
	}

}