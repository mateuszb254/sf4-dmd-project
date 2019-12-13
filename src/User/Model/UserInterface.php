<?php

namespace App\User\Model;

use App\Character\Entity\CharacterIndex;
use App\User\Entity\RoleGroup;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends BaseUserInterface
{
    /** @var string */
    public const ROLE_GLOBAL_ADMIN = 'ROLE_GLOBAL_ADMIN';

    /** @var string */
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /** @var string */
    public const DEFAULT_ROLE = 'ROLE_USER';

    public function getId(): ?int;

    public function getCharRemovalCode();

    public function setCharRemovalCode(string $charRemovalCode);

    public function getStatus(): string;

    public function setStatus(string $status): UserInterface;

    public function getBanTime(): ?\DateTime;

    public function setBanTime(\DateTime $banTime): UserInterface;

    public function getBanReason(): ?string;

    public function setBanReason(?string $reason): UserInterface;

    public function getCoins(): int;

    public function setCoins(int $login): UserInterface;

    public function addCoins(int $amount): UserInterface;

    public function getEmail(): ?string;

    public function setEmail(string $email): UserInterface;

    public function getLogin(): ?string;

    public function setLogin(string $login): UserInterface;

    public function getPassword(): ?string;

    public function setPassword(string $password);

    public function isGlobalAdmin(): bool;

    public function getRoleGroup(): ?RoleGroup;

    public function setRoleGroup(?RoleGroup $roleGroup): UserInterface;

    public function getEmailChangeToken(): ?string;

    public function setEmailChangeToken(?string $emailChangeToken): UserInterface;

    public function getEmailChangeTokenCreatedAt(): ?\DateTime;

    public function setEmailChangeTokenCreatedAt(?\DateTime $emailChangeTokenCreatedAt);

    public function getPasswordResetToken(): ?string;

    public function setPasswordResetToken(?string $passwordResetToken): UserInterface;

    public function getPasswordResetTokenCreatedAt(): ?\DateTime;

    public function setPasswordResetTokenCreatedAt(?\DateTime $passwordResetTokenCreatedAt);

    public function getPlainPassword(): ?string;

    public function setPlainPassword(string $plainPassword);

    public function getSecurityQuestion(): ?string;

    public function setSecurityQuestion(string $securityQuestion): UserInterface;

    public function getSecurityAnswer(): ?string;

    public function setSecurityAnswer(string $securityAnswer): UserInterface;

    public function getBronzeVip(): ?\DateTime;

    public function setBronzeVip(\DateTime $vipExpires): UserInterface;

    public function getSilverVip(): ?\DateTime;

    public function setSilverVip(\DateTime $vipExpires): UserInterface;

    public function getGoldVip(): ?\DateTime;

    public function setGoldVip(\DateTime $vipExpires): UserInterface;

    public function getLastActivity(): ?\DateTime;

    public function setLastActivity(\DateTime $dateTime): UserInterface;

    public function getLastIp(): ?string;

    public function setLastIp(string $ip): UserInterface;

    public function getCharacters();

    public function getCharacterIndex(): ?CharacterIndex;

    public function getEmpire(): ?int;

    public function isBanned(): bool;

    public function isResetPasswordTokenExpired(): bool;

    public function isChangeEmailTokenExpired(): bool;
}
