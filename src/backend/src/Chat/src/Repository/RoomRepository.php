<?php

namespace CASS\Chat\Repository;

use CASS\Chat\Entity\Room;
use Doctrine\ORM\EntityRepository;

class RoomRepository extends EntityRepository
{
    public function roomSave(Room $room): Room
    {
        $em = $this->getEntityManager();

        $em->persist($room);
        $em->flush();

        return $room;
    }

}