<?php
namespace CASS\Chat;

use CASS\Chat\Entity\Message;
use CASS\Chat\Entity\Room;
use CASS\Chat\Repository\MessageRepository;
use CASS\Chat\Repository\RoomRepository;
use function \DI\factory;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;

return [
    'php-di' => [
        MessageRepository::class => factory(new DoctrineRepositoryFactory(Message::class) ),
        RoomRepository::class => factory(new DoctrineRepositoryFactory(Room::class))
    ]
];