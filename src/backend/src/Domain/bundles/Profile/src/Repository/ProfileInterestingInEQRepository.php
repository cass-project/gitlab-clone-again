<?php
namespace CASS\Domain\Bundles\Profile\Repository;

use Doctrine\ORM\EntityRepository;
use CASS\Domain\Bundles\Profile\Entity\ProfileInterestingInEQ;

class ProfileInterestingInEQRepository extends EntityRepository
{
    public function saveEQ(array $entities)
    {
        foreach($entities as $entity) {
            $this->getEntityManager()->persist($entity);
        }

        $this->getEntityManager()->flush($entities);
    }

    public function sync(int $profileId, array $themeIds)
    {
        $this->deleteEQOfProfile($profileId);
        $this->saveEQ(array_map(function(int $themeId) use ($profileId) {
            return new ProfileInterestingInEQ($profileId, $themeId);
        }, $themeIds));
    }

    public function deleteEQOfProfile(int $profileId)
    {
        $em = $this->getEntityManager();

        $em->flush(array_map(function(ProfileInterestingInEQ $eq) use ($em) {
            $em->remove($eq);

            return $eq;
        }, $this->findBy([
            'profileId' => $profileId
        ])));
    }

    public function deleteEQOfTheme(int $themeId)
    {
        $em = $this->getEntityManager();

        $em->flush(array_map(function(ProfileInterestingInEQ $eq) use ($em) {
            $em->remove($eq);

            return $eq;
        }, $this->findBy([
            'themeId' => $themeId
        ])));
    }

    public function getProfilesByThemeId(int $themeId): array
    {
        /** @var int[] $result */
        $result = $this->findBy([
            'themeId' => $themeId
        ]);

        return $result;
    }
}