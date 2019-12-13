<?php

namespace App\Log\Entity;

use App\Core\Util\Timestamp\Model\TimestampableTrait;
use App\User\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Log\Repository\UserLogRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap({
 *     "AUTHENTICATION_FAILURE" : "App\Log\Entity\AuthenticationFailedUserLog",
 *     "AUTHENTICATION_SUCCESS" : "App\Log\Entity\AuthenticationSuccessfulUserLog",
 *     "DATA_CHANGE_PASSWORD" : "App\Log\Entity\DataChangePasswordUserLog",
 *     "DATA_CHANGE_EMAIL" : "App\Log\Entity\DataChangeEmailUserLog",
 *     "DATA_CHANGE_REMOVAL_CODE" : "App\Log\Entity\DataChangeRemovalCodeUserLog"
 * })
 */
abstract class UserLog
{
    const PER_PAGE = 25;

    use TimestampableTrait;

    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var UserInterface|null
     *
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $ip;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $userAgent;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface|null $user
     * @return UserLog
     */
    public function setUser(?UserInterface $user): UserLog
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return UserLog
     */
    public function setCreatedAt(\DateTime $createdAt): UserLog
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return UserLog
     */
    public function setIp(string $ip): UserLog
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    /**
     * @param string|null $userAgent
     *
     * @return self;
     */
    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }
}
