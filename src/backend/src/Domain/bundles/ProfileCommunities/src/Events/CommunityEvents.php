<?php
namespace CASS\Domain\Bundles\ProfileCommunities\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use CASS\Domain\Bundles\ProfileCommunities\Service\ProfileCommunitiesService;
use Evenement\EventEmitterInterface;

final class CommunityEvents implements EventsBootstrapInterface
{
    /** @var CommunityService */
    private $communityService;

    /** @var ProfileCommunitiesService */
    private $profileCommunitiesService;

    public function __construct(
        CommunityService $communityService,
        ProfileCommunitiesService $profileCommunitiesService
    ) {
        $this->communityService = $communityService;
        $this->profileCommunitiesService = $profileCommunitiesService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $this->communityService->getEventEmitter()->on(CommunityService::EVENT_COMMUNITY_CREATED, function(Community $community) {
            $this->profileCommunitiesService->joinToCommunity(
                $community->getOwner()->getCurrentProfile()->getId(),
                $community->getSID()
            );
        });
    }
}