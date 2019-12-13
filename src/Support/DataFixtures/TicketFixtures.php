<?php

namespace App\Support\DataFixtures;

use App\Support\Entity\Ticket;
use App\User\DataFixtures\UserFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

final class TicketFixtures extends Fixture implements DependentFixtureInterface
{
    public const TICKETS_AMOUNT = 20;

    public const TICKET_TITLE_BASE = 'ticket-title-';
    public const TICKET_CONTENT_BASE = 'ticket-content-';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getTickets() as [$title, $content]) {
            $ticket = new Ticket();

            $ticket->setTitle($title);
            $ticket->setContent($content);
            $ticket->setAuthor($this->getReference(UserFixture::USER_AUTH_DATA . '_REFERENCE'));
            $ticket->setCreatedAt(new \DateTime());

            $ticket->setCategory(
                $this->getReference(
                    CategoryFixtures::class . CategoryFixtures::CATEGORY_TITLE_BASE . rand(1, CategoryFixtures::CATEGORIES_AMOUNT) . '_REFERENCE'
                )
            );

            $this->addReference(__CLASS__ . $title, $ticket);

            $manager->persist($ticket);
        }

        $manager->flush();
    }

    public function getTickets()
    {
        $data = [];

        for ($i = 0; $i < self::TICKETS_AMOUNT; $i++) {
            $data[] = [
                self::TICKET_TITLE_BASE . $i,
                self::TICKET_CONTENT_BASE . $i
            ];
        }

        return $data;
    }

    public function getDependencies()
    {
        return [
            UserFixture::class, CategoryFixtures::class
        ];
    }
}
