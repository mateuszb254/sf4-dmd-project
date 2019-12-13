<?php

namespace App\User\DataFixtures;

use App\User\Entity\RoleGroup;
use App\User\Permissions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoleGroupFixtures extends Fixture
{
    public const ROLE_GROUP_ADMIN_REFERENCE = 'ROLE_GROUP_ADMIN_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $roleGroup = new RoleGroup();
        $roleGroup->setName('CUSTOM_ADMINISTRATOR');
        $roleGroup->setPermissions([
                Permissions::ARTICLE_CAN_BROWSE_SECTION, Permissions::ARTICLE_CAN_ADD,
                Permissions::ARTICLE_CAN_EDIT, Permissions::ARTICLE_CAN_DELETE
            ]
        );

        $manager->persist($roleGroup);
        $manager->flush();

        $this->addReference(self::ROLE_GROUP_ADMIN_REFERENCE, $roleGroup);
    }
}
