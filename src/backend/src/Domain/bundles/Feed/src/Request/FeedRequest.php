<?php
namespace CASS\Domain\Bundles\Feed\Request;

use CASS\Domain\Bundles\Feed\Exception\InvalidJSONParamsException;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\CriteriaFactory;
use CASS\Domain\Bundles\Feed\Search\Criteria\CriteriaManager;

final class FeedRequest
{
    /** @var CriteriaManager */
    private $criteria;

    public function __construct(array $criteria)
    {
        $this->criteria = new CriteriaManager();

        array_map(function(Criteria $criteria) {
            $this->criteria->attachCriteria($criteria);
        }, $criteria);
    }

    public static function createFromJSON(CriteriaFactory $criteriaFactory, array $json)
    {
        return new self(array_map(function(array $arrCriteria) use ($criteriaFactory): Criteria {
            $testIsArray = is_array($arrCriteria);
            $testHasCode = isset($arrCriteria['code']) && strlen($arrCriteria['code']) > 0;
            $testHasParams = isset($arrCriteria['params']) && is_array($arrCriteria['params']);
            
            if(! ($testIsArray && $testHasCode && $testHasParams)) {
                throw new InvalidJSONParamsException('Invalid JSON params');
            }

            $criteria = $criteriaFactory->createFromStringCode($arrCriteria['code']);
            $criteria->unpack($arrCriteria['params']);

            return $criteria;
        }, $json));
    }

    public function getCriteria(): CriteriaManager
    {
        return $this->criteria;
    }
}