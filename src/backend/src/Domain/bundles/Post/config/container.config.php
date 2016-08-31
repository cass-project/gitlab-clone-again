<?php
namespace Domain\Post;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Post\Entity\Post;
use Domain\Post\Entity\PostThemeEQ;
use Domain\Post\Repository\PostRepository;
use Domain\Post\Repository\PostThemeEQRepository;

return [
    'php-di' => [
        PostRepository::class => factory(new DoctrineRepositoryFactory(Post::class)),
        PostThemeEQRepository::class => factory(new DoctrineRepositoryFactory(PostThemeEQ::class)),
    ]
];