<?php

namespace App\User\Entity;

use App\Character\Entity\CharacterIndex;
use App\Core\Util\Timestamp\Model\TimestampableTrait;
use App\User\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\User\Repository\UserRepository")
 *
 * @UniqueEntity("login")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    use TimestampableTrait;

    /** @var string */
    public const LOGIN_REGEX_PATTERN = '/^[a-zA-Z0-9_]+$/';

    /** @var string */
    public const STATUS_OK = 'OK';

    /** @var string */
    public const STATUS_BANNED_PERM = 'BLOCK';

    /** @var int Unix timestamp */
    public const EMAIL_CHANGE_TOKEN_LIFE = 3600;

    /** @var int Unix timestamp */
    public const RESET_PASSWORD_TOKEN_LIFE = 3600;

    /** @var int */
    public const PER_PAGE = 25;

    /**
     * @var integer|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string|null $login
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="15")
     * @Assert\Regex(
     *     pattern=User::LOGIN_REGEX_PATTERN,
     *     message="login_invalid_pattern"
     * )
     *
     * @ORM\Column(name="login", type="string", length=30, nullable=false, unique=true)
     */
    private $login;

    /**
     * @var string|null $email
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(min="5", max="64")
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=false, unique=false)
     */
    private $email;

    /**
     * Password before encryption. Must not be persisted.
     *
     * @Assert\Length(max="4096")
     *
     * @var string $plainPassword
     **/
    private $plainPassword;

    /**
     * @var string|null $password
     *
     * @ORM\Column(name="password", type="string", length=41, nullable=false)
     */
    private $password;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_global", options={"default" : false}, nullable=true)
     */
    private $isGlobalAdmin = false;

    /**
     * @var RoleGroup
     *
     * @ORM\ManyToOne(targetEntity="App\User\Entity\RoleGroup", inversedBy="users")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $roleGroup;

    /**
     * @var string|null $charRemovalCode
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=10)
     *
     * @ORM\Column(name="char_removal_code", type="string", length=10, nullable=false)
     */
    private $charRemovalCode;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", options={"default" : User::STATUS_OK }, nullable=false)
     */
    private $status = self::STATUS_OK;

    /**
     * @var \DateTime|null $banTime
     *
     * @ORM\Column(name="availDt", type="datetime", nullable=true)
     */
    private $banTime;

    /**
     * @var string|null $banReason
     *
     * @ORM\Column(name="ban_reason", type="string", nullable=true, length=255)
     */
    private $banReason;

    /**
     * @var int $coins
     *
     * @ORM\Column(name="coins", type="integer", options={"default" : 0}, nullable=false)
     */
    private $coins = 0;

    /**
     * @var string|null $securityQuestion
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="security_question", type="string", length=255, nullable=true)
     */
    private $securityQuestion;

    /**
     * @var string|null $securityAnswer
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="security_answer", type="string", length=255, nullable=true)
     */
    private $securityAnswer;

    /**
     * @var string|null $emailChangeToken
     *
     * @ORM\Column(name="email_change_token", type="string", length=25, nullable=true)
     */
    private $emailChangeToken;

    /**
     * @var \DateTime|null $emailChangeTokenCreatedAt
     *
     * @ORM\Column(name="email_change_token_created_at", type="datetime", nullable=true)
     */
    private $emailChangeTokenCreatedAt;

    /**
     * @var string|null $passwordResetToken
     *
     * @ORM\Column(name="password_reset_token", type="string", length=25, nullable=true)
     */
    private $passwordResetToken;

    /**
     * @var \DateTime|null $passwordResetTokenCreatedAt
     *
     * @ORM\Column(name="password_reset_token_created_at", type="datetime", nullable=true)
     */
    private $passwordResetTokenCreatedAt;

    /**
     * @var \DateTime|null $bronzeVip
     *
     * @ORM\Column(name="money_drop_rate_expire", type="datetime", nullable=true)
     */
    private $bronzeVip;

    /**
     * @var \DateTime|null $silverVip
     *
     * @ORM\Column(name="silver_expire", type="datetime", nullable=true)
     */
    private $silverVip;

    /**
     * @var \DateTime|null $goldVip
     *
     * @ORM\Column(name="gold_expire", type="datetime", nullable=true)
     */
    private $goldVip;

    /**
     * @var \DateTime|null $lastActivity
     *
     * @ORM\Column(name="last_play", type="datetime", nullable=true)
     */
    private $lastPlay;

    /**
     * @var \DateTime|null $lastActivity
     *
     * @ORM\Column(name="last_activity", type="datetime", options={"default": null}, nullable=true)
     */
    private $lastActivity;

    /**
     * @var string|null $lastIp
     *
     * @ORM\Column(name="last_ip", type="string", nullable=true)
     */
    private $lastIp;

    /**
     * @var PersistentCollection $characters
     *
     * @ORM\OneToMany(targetEntity="App\Character\Entity\Character", mappedBy="user")
     */
    private $characters;

    /**
     * @var CharacterIndex|null $characterIndex
     *
     * @ORM\OneToOne(targetEntity="App\Character\Entity\CharacterIndex", mappedBy="id")
     */
    private $charactersIndex;

    /**
     * @var PersistentCollection $tickets
     *
     * @ORM\OneToMany(targetEntity="App\Support\Entity\Ticket", mappedBy="author")
     */
    private $tickets;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string $login
     *
     * @return self
     */
    public function setLogin(string $login): UserInterface
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): UserInterface
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return self
     */
    public function setPlainPassword(string $plainPassword): UserInterface
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): UserInterface
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCharRemovalCode(): ?string
    {
        return $this->charRemovalCode;
    }

    /**
     * @param string $charRemovalCode
     * @return self
     */
    public function setCharRemovalCode(string $charRemovalCode): UserInterface
    {
        $this->charRemovalCode = $charRemovalCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): UserInterface
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getBanTime(): ?\DateTime
    {
        return $this->banTime;
    }

    /**
     * @param \DateTime|null $banTime
     * @return self
     */
    public function setBanTime(?\DateTime $banTime): UserInterface
    {
        $this->banTime = $banTime;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBanReason(): ?string
    {
        return $this->banReason;
    }

    /**
     * @param string|null $reason
     * @return self
     */
    public function setBanReason(?string $reason): UserInterface
    {
        $this->banReason = $reason;

        return $this;
    }

    /**
     * @param int $coins
     * @return self
     */
    public function setCoins(int $coins): UserInterface
    {
        $this->coins = $coins;

        return $this;
    }

    /**
     * @return self
     */
    public function getCoins(): int
    {
        return $this->coins;
    }

    /**
     * @param int $amount
     * @return UserInterface
     */
    public function addCoins(int $amount): UserInterface
    {
        $this->coins += $amount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecurityQuestion(): ?string
    {
        return $this->securityQuestion;
    }

    /**
     * @param string $securityQuestion
     *
     * @return self
     */
    public function setSecurityQuestion(string $securityQuestion): UserInterface
    {
        $this->securityQuestion = $securityQuestion;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecurityAnswer(): ?string
    {
        return $this->securityAnswer;
    }

    /**
     * @param string $securityAnswer
     *
     * @return self
     */
    public function setSecurityAnswer(string $securityAnswer): UserInterface
    {
        $this->securityAnswer = $securityAnswer;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailChangeToken(): ?string
    {
        return $this->emailChangeToken;
    }

    /**
     * @param string|null $emailChangeToken
     *
     * @return self
     */
    public function setEmailChangeToken(?string $emailChangeToken): UserInterface
    {
        $this->emailChangeToken = $emailChangeToken;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getEmailChangeTokenCreatedAt(): ?\DateTime
    {
        return $this->emailChangeTokenCreatedAt;
    }

    /**
     * @param \DateTime|null $emailChangeTokenCreatedAt
     *
     * @return self
     */
    public function setEmailChangeTokenCreatedAt(?\DateTime $emailChangeTokenCreatedAt): UserInterface
    {
        $this->emailChangeTokenCreatedAt = $emailChangeTokenCreatedAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    /**
     * @param string|null $passwordResetToken
     *
     * @return self
     */
    public function setPasswordResetToken(?string $passwordResetToken): UserInterface
    {
        $this->passwordResetToken = $passwordResetToken;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPasswordResetTokenCreatedAt(): ?\DateTime
    {
        return $this->passwordResetTokenCreatedAt;
    }

    /**
     * @param \DateTime|null $passwordResetTokenCreatedAt
     *
     * @return self
     */
    public function setPasswordResetTokenCreatedAt(?\DateTime $passwordResetTokenCreatedAt): UserInterface
    {
        $this->passwordResetTokenCreatedAt = $passwordResetTokenCreatedAt;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getBronzeVip(): ?\DateTime
    {
        return $this->bronzeVip;
    }

    /**
     * @param \DateTime|null $vipExpires
     *
     * @return $this
     */
    public function setBronzeVip(?\DateTime $vipExpires): UserInterface
    {
        $this->silverVip = $vipExpires;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getSilverVip(): ?\DateTime
    {
        return $this->silverVip;
    }

    /**
     * @param \DateTime|null $vipExpires
     *
     * @return $this
     */
    public function setSilverVip(?\DateTime $vipExpires): UserInterface
    {
        $this->silverVip = $vipExpires;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getGoldVip(): ?\DateTime
    {
        return $this->goldVip;
    }

    /**
     * @param \DateTime|null $vipExpires
     *
     * @return $this
     */
    public function setGoldVip(?\DateTime $vipExpires): UserInterface
    {
        $this->goldVip = $vipExpires;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastPlay(): ?\DateTime
    {
        return $this->lastPlay;
    }

    /**
     * @param \DateTime|null $lastPlay
     *
     * @return self
     */
    public function setLastPlay(?\DateTime $lastPlay): UserInterface
    {
        $this->lastActivity = $lastPlay;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastActivity(): ?\DateTime
    {
        return $this->lastActivity;
    }

    /**
     * @param \DateTime|null $lastActivity
     *
     * @return self
     */
    public function setLastActivity(?\DateTime $lastActivity): UserInterface
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastIp(): ?string
    {
        return $this->lastIp;
    }

    /**
     * @param string|null $lastIp
     *
     * @return self
     */
    public function setLastIp(?string $lastIp): UserInterface
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getCharacters(): PersistentCollection
    {
        return $this->characters;
    }

    /**
     * @return CharacterIndex|null
     */
    public function getCharacterIndex(): ?CharacterIndex
    {
        return $this->charactersIndex;
    }

    /**
     * @return int|null
     */
    public function getEmpire(): ?int
    {
        $characterIndex = $this->charactersIndex;

        if ($characterIndex instanceof CharacterIndex) {
            return $characterIndex->getEmpire();
        }

        return null;
    }

    /**
     * @return PersistentCollection
     */
    public function getTickets(): PersistentCollection
    {
        return $this->tickets;
    }

    /**
     * @param bool $isGlobal
     * @return self
     */
    public function setGlobalAdmin(bool $isGlobal): self
    {
        $this->isGlobalAdmin = $isGlobal;

        return $this;
    }

    /**
     * @return bool
     */
    public function isGlobalAdmin(): bool
    {
        return $this->isGlobalAdmin;
    }

    /**
     * @return RoleGroup|null
     */
    public function getRoleGroup(): ?RoleGroup
    {
        return $this->roleGroup;
    }

    /**
     * @param RoleGroup|null $roleGroup
     * @return User
     */
    public function setRoleGroup(?RoleGroup $roleGroup): UserInterface
    {
        $this->roleGroup = $roleGroup;

        return $this;
    }

    public function getRoles(): array
    {
        if ($this->isGlobalAdmin) return [self::ROLE_GLOBAL_ADMIN];

        $roleGroup = $this->getRoleGroup();

        return $roleGroup ? array_merge($roleGroup->getPermissions(), [self::ROLE_ADMIN]) : [self::DEFAULT_ROLE];
    }

    public function getSalt()
    {

    }

    public function getUsername(): string
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function isBanned(): bool
    {
        return $this->getStatus() === self::STATUS_BANNED_PERM || $this->getBanTime() >= new \DateTime();
    }

    public function isResetPasswordTokenExpired(): bool
    {
        $tokenCreatedAt = $this->getPasswordResetTokenCreatedAt();

        return
            $tokenCreatedAt instanceof \DateTime &&
            $tokenCreatedAt->getTimestamp() + self::RESET_PASSWORD_TOKEN_LIFE < time();
    }

    public function isChangeEmailTokenExpired(): bool
    {
        $tokenCreatedAt = $this->getEmailChangeTokenCreatedAt();

        return
            $tokenCreatedAt instanceof \DateTime &&
            $tokenCreatedAt->getTimestamp() + self::EMAIL_CHANGE_TOKEN_LIFE < time();
    }

    public function __toString(): string
    {
        return $this->login;
    }
}
