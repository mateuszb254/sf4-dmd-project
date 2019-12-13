<?php

namespace App\User\DataFixtures;

use App\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

final class UserFixture extends Fixture implements DependentFixtureInterface
{
    public const GLOBAL_ADMIN_AUTH_DATA = 'global_admin';
    public const ADMIN_AUTH_DATA = 'admin';
    public const USER_AUTH_DATA = 'user';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUsersData() as $userData) {
            $user = new User();

            $user->setLogin($userData['login']);
            $user->setPlainPassword($userData['plainPassword']);
            $user->setEmail($userData['email']);
            $user->setCharRemovalCode($userData['char_removal_code']);
            $user->setGlobalAdmin($userData['isGlobal']);
            $user->setSecurityQuestion($userData['security_question']);
            $user->setSecurityAnswer($userData['security_answer']);
            $user->setStatus($userData['status'] ?? User::STATUS_OK);
            $user->setBanReason($userData['reason'] ?? null);
            $user->setBanTime($userData['banTime'] ?? null);

            if (array_key_exists('roleGroup', $userData)) $user->setRoleGroup($userData['roleGroup']);

            $this->setReference($userData['login'] . '_REFERENCE', $user);


            $manager->persist($user);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [RoleGroupFixtures::class];
    }

    protected function getUsersData(): array
    {
        return [
            [
                'login' => self::GLOBAL_ADMIN_AUTH_DATA,
                'plainPassword' => self::GLOBAL_ADMIN_AUTH_DATA,
                'email' => 'global_admin@domain.ext',
                'char_removal_code' => 111111,
                'isGlobal' => true,
                'security_question' => 'a security question',
                'security_answer' => 'an answer'
            ],
            [
                'login' => self::ADMIN_AUTH_DATA,
                'plainPassword' => self::ADMIN_AUTH_DATA,
                'email' => 'admin@domain.ext',
                'char_removal_code' => 111111,
                'isGlobal' => false,
                'security_question' => 'a security question',
                'security_answer' => 'an answer',
                'roleGroup' => $this->getReference(RoleGroupFixtures::ROLE_GROUP_ADMIN_REFERENCE)
            ],
            [
                'login' => self::USER_AUTH_DATA,
                'plainPassword' => self::USER_AUTH_DATA,
                'email' => 'user@domain.ext',
                'char_removal_code' => 111111,
                'isGlobal' => false,
                'security_question' => 'a security question',
                'security_answer' => 'an answer'
            ],
            [
                'login' => 'user_banned1',
                'plainPassword' => self::USER_AUTH_DATA,
                'email' => 'user_banned1@domain.ext',
                'char_removal_code' => 022211,
                'isGlobal' => false,
                'security_question' => 'a security question',
                'security_answer' => 'an answer',
                'status' => User::STATUS_OK,
                'banTime' => (new \DateTime())->modify('+7DAYS'),
                'reason' => 'a reason of the ban'
            ],
            [
                'login' => 'user_banned2',
                'plainPassword' => self::USER_AUTH_DATA,
                'email' => 'user_banned1@domain.ext',
                'char_removal_code' => 022211,
                'isGlobal' => false,
                'security_question' => 'a security question',
                'security_answer' => 'an answer',
                'status' => User::STATUS_BANNED_PERM,
                'reason' => 'a reason of the ban'
            ]
        ];
    }
}
