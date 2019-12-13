<?php

namespace App\Support\DataFixtures;

use App\Support\Entity\TicketCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class CategoryFixtures extends Fixture
{
    public const CATEGORIES_AMOUNT = 3;

    public const CATEGORY_TITLE_BASE = 'category-';

    public function load(ObjectManager $manager)
    {
        $priority = 1;

        foreach ($this->getCategories() as [$name]) {
            $category = new TicketCategory();

            $category->setName($name);
            $category->setPriority($priority);

            $manager->persist($category);

            $this->setReference(__CLASS__ . $name . '_REFERENCE', $category);

            $priority++;
        }

        $manager->flush();
    }

    public function getCategories()
    {
        $data = [];

        for ($i = 1; $i <= self::CATEGORIES_AMOUNT; $i++) {
            $data[] = [
                self::CATEGORY_TITLE_BASE . $i
            ];
        }

        return $data;;
    }

}
