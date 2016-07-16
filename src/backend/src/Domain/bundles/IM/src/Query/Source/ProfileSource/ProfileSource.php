<?php
namespace Domain\IM\Query\Source\ProfileSource;

use Domain\IM\Exception\Query\InvalidSourceParamsException;
use Domain\IM\Query\Source\Source;

final class ProfileSource implements Source
{
    const SOURCE_CODE = 'profile';

    /** @var int */
    private $sourceProfileId;

    /** @var int */
    private $targetProfileId;

    public function __construct(int $sourceProfileId, int $targetProfileId)
    {
        $this->sourceProfileId = $sourceProfileId;
        $this->targetProfileId = $targetProfileId;
    }

    public static function getCode(): string
    {
        return self::SOURCE_CODE;
    }

    public static function createFromParams(array $params): Source
    {
        $sourceProfileId = $params['source_profile_id'] ?? 0;
        $targetProfileId = $params['target_profile_id'] ?? 0;

        if($sourceProfileId <= 0 || $targetProfileId <= 0) {
            throw new InvalidSourceParamsException('Invalid source/targer profile Id');
        }

        return new self($sourceProfileId, $targetProfileId);
    }

    public function getMongoDBCollectionName(): string
    {
        return sprintf(
            'im_profile_%s_%s',
            min($this->sourceProfileId, $this->targetProfileId),
            min($this->sourceProfileId, $this->targetProfileId)
        );
    }

    public function getSourceProfileId(): int
    {
        return $this->sourceProfileId;
    }

    public function getTargetProfileId(): int
    {
        return $this->targetProfileId;
    }
}