<?php
namespace CASS\Domain\Bundles\Collection\Repository;

use Doctrine\ORM\EntityRepository;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;

class CollectionRepository extends EntityRepository
{
    public function createCollection(Collection $collection): Collection
    {
        $em = $this->getEntityManager();
        $em->persist($collection);
        $em->flush($collection);

        return $collection;
    }

    public function saveCollection(Collection $collection): Collection
    {
        $em = $this->getEntityManager();
        $em->flush($collection);

        return $collection;
    }

    public function deleteCollection(int $collectionId)
    {
        $collection = $this->getCollectionById($collectionId);

        $this->getEntityManager()->remove($collection);
        $this->getEntityManager()->flush($collection);
    }

    public function getCollectionById(int $collectionId): Collection
    {
        $result = $this->find($collectionId);

        if($result === null) {
            throw new CollectionNotFoundException(sprintf('Collection with ID `%d` not found', $collectionId));
        }

        return $result;
    }

    public function getCollectionBySID(string $collectionSID): Collection
    {
        /** @var Collection|null $result */
        $result = $this->findOneBy([
            'sid' => $collectionSID,
        ]);

        if($result === null) {
            throw new CollectionNotFoundException(sprintf('Collection with SID `%d` not found', $collectionSID));
        }

        return $result;
    }


    public function getCollectionsById(array $collectionIds): array
    {
        return $this->findBy(['id' => $collectionIds]);
    }
}