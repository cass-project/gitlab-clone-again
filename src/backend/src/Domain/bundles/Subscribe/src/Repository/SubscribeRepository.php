<?php
namespace CASS\Domain\Bundles\Subscribe\Repository;

use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Exception\UnknownSubscribeException;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use Doctrine\ORM\EntityRepository;

class SubscribeRepository extends EntityRepository
{
    public function subscribeTheme(Profile $profile, Theme $theme, $options = null): Subscribe
    {
        $subscribe =  new Subscribe();
        $subscribe->setProfileId($profile->getId())
            ->setOptions($options)
            ->setSubscribeId($theme->getId())
            ->setSubscribeType(Subscribe::TYPE_THEME);

        $em = $this->getEntityManager();
        $em->persist($subscribe);
        $em->flush();
        return $subscribe;
    }

    public function unSubscribeTheme(Profile $profile, Theme $theme){

        $criteria = ['profile_id' => $profile->getId(), 'theme_id' => $theme->getId(), 'type' => Subscribe::TYPE_THEME ];
        $subscribe = $this->getSubscribe($criteria);

        $em = $this->getEntityManager();
        $em->remove($subscribe);
        $em->flush();

    }

    public function getSubscribeById(int $id):Subscribe
    {   
        $subscribe = $this->getEntityManager()->getRepository(Subscribe::class)->find($id);
        if ($subscribe === null) throw new UnknownSubscribeException(sprintf("Subscribe id:%s not found", $id));
        return $subscribe;
    }

    public function getSubscribe(array $criteria): Subscribe
    {
        $subscribe = $this->getEntityManager()->getRepository(Subscribe::class)->findOneBy($criteria);
        if ($subscribe === null)
            throw new UnknownSubscribeException(
                sprintf("Subscribe not found - (profile_id: %s, subscribe_id: %s, subscribe_type): %s",
                    $criteria['profile_id'],
                    $criteria['subscribe_id'],
                    $criteria['type']
                )
            );
        return $subscribe;
    }
}