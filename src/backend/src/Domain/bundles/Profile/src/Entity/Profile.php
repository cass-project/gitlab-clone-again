<?php
namespace Domain\Profile\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\Entity\SIDEntity\SIDEntity;
use Application\Util\Entity\SIDEntity\SIDEntityTrait;
use Application\Util\JSONSerializable;
use Domain\Account\Entity\Account;
use Domain\Avatar\Entity\ImageEntity;
use Domain\Avatar\Entity\ImageEntityTrait;
use Domain\Avatar\Image\ImageCollection;
use Domain\Collection\Collection\CollectionTree\ImmutableCollectionTree;
use Domain\Collection\Strategy\CollectionAwareEntity;
use Domain\Collection\Strategy\Traits\CollectionAwareEntityTrait;;
use Domain\Index\Entity\IndexedEntity;
use Domain\Profile\Entity\Profile\Gender\Gender;
use Domain\Profile\Entity\Profile\Gender\GenderNotSpecified;
use Domain\Profile\Entity\Profile\Greetings\Greetings;
use Domain\Profile\Entity\Profile\Greetings\GreetingsAnonymous;
use Domain\Profile\Exception\InvalidBirthdayException;
use Domain\Profile\Exception\InvalidBirthdayGuestFromTheFutureException;

/**
 * @Entity(repositoryClass="Domain\Profile\Repository\ProfileRepository")
 * @Table(name="profile")
 */
class Profile implements JSONSerializable, IdEntity, SIDEntity, ImageEntity, CollectionAwareEntity, IndexedEntity
{
    const MIN_AGE = 3;
    const MAX_AGE = 130;

    const EXCEPTION_GUEST_FUTURE = "Hello stranger, does nuclear war happen?";
    const EXCEPTION_YOUNG = "You're too young, where are your parents?";
    const EXCEPTION_OLD = "You're too old, where is your grave?";

    use IdTrait;
    use SIDEntityTrait;
    use CollectionAwareEntityTrait;
    use ImageEntityTrait;

    /**
     * @ManyToOne(targetEntity="Domain\Account\Entity\Account")
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * @Column(type="datetime", name="date_created_on")
     * @var \DateTime
     */
    private $dateCreatedOn;

    /**
     * @Column(type="boolean", name="is_initialized")
     * @var bool
     */
    private $isInitialized = false;

    /**
     * @var bool
     * @Column(type="integer", name="is_current")
     */
    private $isCurrent = false;

    /**
     * @Column(type="object", name="greetings")
     * @var Greetings
     */
    private $greetings;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $gender;

    /**
     * @Column(type="datetime", name="birthday")
     * @var \DateTime|null
     */
    private $birthday;

    /**
     * @Column(type="json_array", name="interesting_in_ids")
     * @var int[]
     */
    private $interestingInIds = [];

    /**
     * @Column(type="json_array", name="expert_in_ids")
     * @var int[]
     */
    private $expertInIds = [];

    public function toJSON(): array
    {
        $result = [
            'id' => $this->isPersisted() ? $this->getId() : '#NEW_PROFILE',
            'sid' => $this->getSID(),
            'account_id' => $this->getAccount()->isPersisted()
                ? $this->getAccount()->getId()
                : '#NEW_ACCOUNT'
            ,
            'date_created_on' => $this->getDateCreatedOn()->format(\DateTime::RFC2822),
            'is_current' => (bool)$this->isCurrent(),
            'is_initialized' => $this->isInitialized(),
            'greetings' => $this->getGreetings()->toJSON(),
            'gender' => $this->getGender()->toJSON(),
            'image' => $this->getImages()->toJSON(),
            'expert_in_ids' => $this->expertInIds,
            'interesting_in_ids' => $this->interestingInIds,
            'collections' => $this->getCollections()->toJSON(),
        ];

        if($this->isBirthdaySpecified()) {
            $result['birthday'] = $this->getBirthday()->format(\DateTime::RFC2822);
        }

        return $result;
    }

    public function toIndexedEntityJSON(): array
    {
        return array_merge($this->toJSON(), [
            'date_created_on' => $this->getDateCreatedOn(),
        ]);
    }

    public function __construct(Account $account)
    {
        $this->account = $account;
        $this->collections = new ImmutableCollectionTree();
        $this->greetings = new GreetingsAnonymous();
        $this->gender = (new GenderNotSpecified())->getIntCode();
        $this->dateCreatedOn = new \DateTime();

        $this->regenerateSID();
        $this->setImages(new ImageCollection());
    }

    public function getDateCreatedOn(): \DateTime
    {
        return $this->dateCreatedOn;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAsInitialized(): self
    {
        $this->isInitialized = true;

        return $this;
    }

    public function isInitialized(): bool
    {
        return (bool)$this->isInitialized;
    }

    public function isCurrent(): bool
    {
        return $this->isCurrent;
    }

    public function setAsCurrent(): self
    {
        $this->isCurrent = true;

        return $this;
    }

    public function unsetAsCurrent(): self
    {
        $this->isCurrent = false;

        return $this;
    }

    public function getGreetings(): Greetings
    {
        return $this->greetings;
    }

    public function setGreetings(Greetings $greetings): self
    {
        $this->isInitialized = true;
        $this->greetings = $greetings;

        return $this;
    }

    public function getGender(): Gender
    {
        return Gender::createFromIntCode($this->gender);
    }

    public function setGender(Gender $gender): self
    {
        $this->gender = $gender->getIntCode();

        return $this;
    }

    public function isBirthdaySpecified(): bool
    {
        return $this->birthday !== null;
    }

    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTime $birthday): self
    {
        $now = new \DateTime();

        if($now < $birthday) {
            throw new InvalidBirthdayGuestFromTheFutureException(self::EXCEPTION_GUEST_FUTURE);
        }

        $diff = $birthday->diff(new \DateTime());
        $years = $diff->y;

        if($years < self::MIN_AGE) {
            throw new InvalidBirthdayException(self::EXCEPTION_YOUNG);
        }

        if($years > self::MAX_AGE) {
            throw new InvalidBirthdayException(self::EXCEPTION_OLD);
        }

        $this->birthday = $birthday;

        return $this;
    }

    public function unsetBirthday(): self
    {
        $this->birthday = null;

        return $this;
    }

    public function getInterestingInIds(): array
    {
        return $this->interestingInIds;
    }

    public function setInterestingInIds(array $themeIds): self
    {
        $this->interestingInIds = array_unique(array_filter($themeIds, 'is_int'));

        return $this;
    }

    public function getExpertInIds(): array
    {
        return $this->expertInIds;
    }

    public function setExpertInIds(array $themeIds): self
    {
        $this->expertInIds = array_unique(array_filter($themeIds, 'is_int'));

        return $this;
    }
}