<?php

namespace CASS\Chat\Middleware\Command;

use CASS\Chat\Entity\Room;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class CreateRoomCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $ownerProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();
            $jsonRequest = json_decode($request->getBody()->getContents(), true);

            $room = new Room();
            $room->setName($jsonRequest['name'])
                ->setOwnerType(Room::OWNER_TYPE_PROFILE)
                ->setOwnerId($ownerProfile->getId())
            ;

            $room = $this->roomService->roomSave($room);

            return $responseBuilder->setStatusSuccess()
                ->setJson([
                    'success' => true,
                    'entity' => $room->toJSON()
                ])
                ->build();

        } catch(\Exception $e) {
            return $responseBuilder
                ->setError($e)
                ->setStatusBadRequest()
                ->build();
        }
    }
}