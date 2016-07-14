<?php
namespace Domain\ProfileIM\Service\LastMessageService;

use Domain\Profile\Entity\Profile;

final class LastMessageServiceQuery
{
    /** @var Profile */
    private $sourceProfile;

    /** @var Profile */
    private $targetProfile;

    public function __construct(Profile $sourceProfile, Profile $targetProfile)
    {
        $this->sourceProfile = $sourceProfile;
        $this->targetProfile = $targetProfile;
    }

    public function getSourceProfile(): Profile
    {
        return $this->sourceProfile;
    }

    public function getTargetProfile(): Profile
    {
        return $this->targetProfile;
    }
}