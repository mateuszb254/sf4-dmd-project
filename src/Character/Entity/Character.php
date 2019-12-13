<?php

namespace App\Character\Entity;

use App\Guild\Entity\Guild;
use App\Guild\Entity\GuildMember;
use App\User\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="characters", indexes={
 *      @ORM\Index(name="search", columns={"level"})
 * })
 * @ORM\Entity(repositoryClass="App\Character\Repository\CharacterRepository")
 *
 * @UniqueEntity("name")
 */
class Character
{
    public const PER_PAGE = 25;
    public const NUMBER_OF_CHARS_SIDEBAR = 25;
    public const MASTERS_EXCLUDED = true;

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
     * @ORM\Column(name="level", type="string", length=30,  options={"default" : 1}, nullable=false)
     */
    private $level = 1;

    /**
     * @var integer $vitality
     *
     * @ORM\Column(name="ht", type="integer", options={"default" : 0}, nullable=false)
     */
    private $vitality = 0;

    /**
     * @var integer $dexterity
     *
     * @ORM\Column(name="dx", type="integer", options={"default" : 0}, nullable=false)
     */
    private $dexterity = 1;

    /**
     * @var integer $vitality
     *
     * @ORM\Column(name="st", type="integer", options={"default" : 0}, nullable=false)
     */
    private $strength = 0;

    /**
     * @var integer $vitality
     *
     * @ORM\Column(name="iq", type="integer", options={"default" : 0}, nullable=false)
     */
    private $intelligence = 0;

    /**
     * @var integer $profession
     *
     * @ORM\Column(name="job", type="integer", options={"default" : 0}, unique=false)
     */
    private $profession = 0;

    /**
     * @var integer $titlePoints
     *
     * @ORM\Column(name="alignment", type="integer", options={"default" : 0}, unique=false)
     */
    private $titlePoints = 0;

    /**
     * @var integer $titlePoints
     *
     * @ORM\Column(name="playtime", type="integer", options={"default" : 0}, unique=false)
     */
    private $playtime = 0;

    /**
     * @var integer $horseLevel
     *
     * @ORM\Column(name="horse_level", type="integer", options={"default" : 0}, unique=false)
     */
    private $horseLevel = 0;

    /**
     * @var GuildMember|null $guildMember
     *
     * @ORM\OneToOne(targetEntity="App\Guild\Entity\GuildMember", mappedBy="character")
     */
    private $guildMember;

    /**
     * @var UserInterface $user
     *
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User", inversedBy="characters")
     * @ORM\JoinColumn(name="account_id", unique=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Character\Entity\GameMaster", mappedBy="character")
     */
    private $gameMaster;

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
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
    public function getVitality(): int
    {
        return $this->vitality;
    }

    /**
     * @param int $vitality
     *
     * @return self
     */
    public function setVitality(int $vitality): self
    {
        $this->vitality = $vitality;

        return $this;
    }

    /**
     * @return int
     */
    public function getDexterity(): int
    {
        return $this->dexterity;
    }

    /**
     * @param int $dexterity
     *
     * @return self
     */
    public function setDexterity(int $dexterity): self
    {
        $this->dexterity = $dexterity;

        return $this;
    }

    /**
     * @return int
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    /**
     * @param int $strength
     *
     * @return self
     */
    public function setStrength(int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * @return int
     */
    public function getIntelligence(): int
    {
        return $this->intelligence;
    }

    /**
     * @param int $intelligence
     *
     * @return self
     */
    public function setIntelligence(int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    /**
     * @return int
     */
    public function getProfession(): int
    {
        return $this->profession;
    }

    /**
     * @param int $profession
     *
     * @return self
     */
    public function setProfession(int $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * @return int
     */
    public function getTitlePoints(): int
    {
        return $this->titlePoints;
    }

    /**
     * @param int $playtime
     *
     * @return self
     */
    public function setPlaytime(int $playtime): self
    {
        $this->playtime = $playtime;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlaytime(): int
    {
        return $this->playtime;
    }

    /**
     * @param int $horseLevel
     *
     * @return self
     */
    public function setHorseLevel(int $horseLevel): self
    {
        $this->horseLevel = $horseLevel;

        return $this;
    }

    /**
     * @return int
     */
    public function getHorseLevel(): int
    {
        return $this->horseLevel;
    }

    /**
     * @return Guild|null
     */
    public function getGuild(): ?Guild
    {
        $guildMember = $this->guildMember;

        if ($guildMember instanceof GuildMember) {
            return $guildMember->getGuild();
        }

        return null;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @return int|null
     */
    public function getEmpire(): ?int
    {
        return $this->user->getEmpire();
    }

    public function isGameMaster(): bool
    {
        return $this->gameMaster instanceof GameMaster;
    }
}
