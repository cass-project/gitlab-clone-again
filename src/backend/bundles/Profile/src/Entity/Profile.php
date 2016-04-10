<?php
namespace Profile\Entity;
use Account\Entity\Account;

/**
 * @Entity(repositoryClass="Profile\Repository\ProfileRepository")
 * @Table(name="profile")
 */
class Profile
{
    /**
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Account\Entity\Account")
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * @var bool
     * @Column(type="integer",name="is_current")
     */
    private $isCurrent = false;

    /**
     * @OneToOne(targetEntity="Profile\Entity\ProfileGreetings", mappedBy="profile", cascade={"persist", "remove"})
     * @var ProfileGreetings
     */
    private $profileGreetings;

    /**
     * @OneToOne(targetEntity="Profile\Entity\ProfileImage", mappedBy="profile", cascade={"persist", "remove"})
     * @var ProfileImage
     */
    private $profileImage;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function hasId(): bool
    {
        return $this->id !== null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAccount(): \Account\Entity\Account
    {
        return $this->account;
    }

    public function isCurrent(): bool
    {
        return $this->isCurrent;
    }

    public function setIsCurrent(bool $isCurrent): self
    {
        $this->isCurrent = $isCurrent;

        return $this;
    }

    public function hasProfileGreetings(): bool
    {
        return $this->profileGreetings !== null;
    }

    public function getProfileGreetings(): ProfileGreetings
    {
        return $this->profileGreetings;
    }

    public function setProfileGreetings(ProfileGreetings $profileGreetings): self
    {
        $this->profileGreetings = $profileGreetings;

        return $this;
    }

    public function hasProfileImage(): bool
    {
        return $this->profileImage !== null;
    }

    public function getProfileImage(): ProfileImage
    {
        return $this->profileImage;
    }

    public function setProfileImage(ProfileImage $profileImage): self
    {
        $this->profileImage = $profileImage;

        return $this;
    }
}