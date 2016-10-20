<?php

namespace CASS\Chat\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdEntityTrait;
use CASS\Util\JSONSerializable;

/**
 * @Entity(repositoryClass="CASS\Chat\Repository\RoomRepository")
 * @Table(name="room")
 */
class Room implements IdEntity, JSONSerializable
{
    use IdEntityTrait;

    const OWNER_TYPE_PROFILE = 1;

    /**
     * @Column(type="string", name="name")
     * @var string
     */
    private $name;

    private $image;

    /**
     * @Column(type="integer", name="owner_id")
     * @var int
     */
    private $ownerId;

    /**
     * @Column(type="integer", name="owner_type")
     * @var int
     */
    private $ownerType;

    /**
     * @Column(type="datetime", name="created")
     * @var \DateTime
     */
    private $created;

    private $accessPrivilege;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getOwnerType()
    {
        return $this->ownerType;
    }

    public function setOwnerType($ownerType)
    {
        $this->ownerType = $ownerType;
        return $this;
    }

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getAccessPrivilege()
    {
        return $this->accessPrivilege;
    }

    public function setAccessPrivilege($accessPrivilege)
    {
        $this->accessPrivilege = $accessPrivilege;
        return $this;
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'owner_id' => $this->ownerId,
            'owner_type' => $this->ownerType,
            'created' => $this->created,
            'access_privilege' => $this->accessPrivilege,
        ];
    }

}