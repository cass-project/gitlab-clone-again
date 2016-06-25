<?php
namespace Domain\Collection\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\JSONSerializable;

/**
 * @Entity(repositoryClass="Domain\Collection\Repository\CollectionThemeEQRepository")
 * @Table(name="collection_theme_ids")
 */
final class CollectionThemeEQEntity implements IdEntity, JSONSerializable
{
    use IdTrait;

    /**
     * @Column(type="integer", name="collection_id")
     * @var int
     */
    private $collectionId;

    /**
     * @Column(type="integer", name="theme_id")
     * @var int
     */
    private $themeId;

    public function __construct(int $collectionId, int $themeId)
    {
        $this->collectionId = $collectionId;
        $this->themeId = $themeId;
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'theme_id' => $this->getThemeId(),
            'collection_id' => $this->getCollectionId()
        ];
    }

    public function getCollectionId(): int
    {
        return $this->collectionId;
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }
}