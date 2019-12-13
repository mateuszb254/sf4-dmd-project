<?php

namespace App\Character\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="gmlist")
 * @ORM\Entity()
 **/
class GameMaster
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="mId", type="integer")
     */
    private $id;

    /**
     * @var string|null $authority
     *
     * @ORM\Column(name="mAuthority", type="string", length=255)
     */
    private $authority;

    /**
     * @ORM\OneToOne(targetEntity="App\Character\Entity\Character", inversedBy="gameMaster")
     * @ORM\JoinColumn(name="character_id")
     */
    private $character;
}
