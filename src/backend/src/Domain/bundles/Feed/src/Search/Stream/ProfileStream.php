<?php
namespace Domain\Feed\Search\Stream;

use Domain\Feed\Search\Criteria\CriteriaManager;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Service\ProfileService;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

final class ProfileStream extends Stream
{
    /** @var ProfileService */
    private $profileService;
    
    public function setProfileService(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }
    
    public function fetch(CriteriaManager $criteriaManager, Collection $collection): array
    {
        $filter = [];
        $options = [];

        $cursor = $collection->find($filter, $options);

        $profileEntities = $this->profileService->getProfilesByIds(array_map(function(BSONDocument $document) {
            return (int) $document['id'];
        }, $cursor->toArray()));

        return array_map(function(Profile $profile) {
            return $profile->toJSON();
        }, $profileEntities);
    }
}