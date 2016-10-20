<?php

namespace CASS\Chat\Service;

use CASS\Chat\Entity\Room;
use CASS\Chat\Repository\RoomRepository;

class RoomService
{
    /** @var RoomRepository  */
    private $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function roomSave(Room $room): Room
    {
        return $this->roomRepository->roomSave($room);
    }



}