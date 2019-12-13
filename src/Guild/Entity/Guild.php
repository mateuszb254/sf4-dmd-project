<?php

namespace App\Guild\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="guild", indexes={
 *      @ORM\Index(name="search", columns={"ladder_point"})
 * })
 * @ORM\Entity(repositoryClass="App\Guild\Repository\GuildRepository")
 *
 * @UniqueEntity("name")
 */
class Guild
{
    public const PER_PAGE = 25;
    public const NUMBER_OF_GUILDS_SIDEBAR = 10;

    /**
     * @var integer $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string|null $name
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="30")
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var integer $level
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="level", type="string", length=30,  options={"default" : 1}, nullable=false)
     */
    private $level = 1;

    /**
     * @var integer $wins
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="win", type="string", length=30,  options={"default" : 0}, nullable=false)
     */
    private $wins = 0;

    /**
     * @var integer $draws
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="draw", type="string", length=30,  options={"default" : 0}, nullable=false)
     */
    private $draws = 0;

    /**
     * @var integer $loses
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="loss", type="string", length=30,  options={"default" : 0}, nullable=false)
     */
    private $loses = 0;

    /**
     * @var integer $titlePoints
     *
     * @ORM\Column(name="ladder_point", type="integer")
     */
    private $ladderPoints = 0;

    /**
     * @var PersistentCollection $characters
     *
     * @ORM\OneToMany(targetEntity="App\Guild\Entity\GuildMember", mappedBy="guild")
     */
    private $members;

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getWins(): int
    {
        return $this->wins;
    }

    /**
     * @return int
     */
    public function getDraws(): int
    {
        return $this->draws;
    }

    /**
     * @return int
     */
    public function getLoses(): int
    {
        return $this->loses;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @return int
     */
    public function getLadderPoints(): int
    {
        return $this->ladderPoints;
    }

    /**
     * @return PersistentCollection
     */
    public function getMembers(): PersistentCollection
    {
        return $this->members;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
