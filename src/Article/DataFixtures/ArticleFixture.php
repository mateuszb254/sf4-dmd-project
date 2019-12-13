<?php

namespace App\Article\DataFixtures;

use App\Article\Entity\Article;
use App\User\DataFixtures\UserFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

final class ArticleFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 15; $i++) {
            $article = new Article();
            $article->setTitle('Praesent id fermentum lorem');
            $article->setContents('
            Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et **dolore magna aliqua**: Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
            deserunt mollit anim id est laborum.
            ');
            $article->setStatus(Article::STATUS_PUBLISHED);
            $article->setCreatedAt(new \DateTime());
            $article->setAuthor(
                $this->getReference(UserFixture::GLOBAL_ADMIN_AUTH_DATA . '_REFERENCE')
            );

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixture::class];
    }
}
