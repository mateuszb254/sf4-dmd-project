<?php

namespace App\Guild\Entity;

use App\Character\Entity\Character;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="guild_member")
 * @ORM\Entity(repositoryClass="App\Guild\Repository\GuildMemberRepository")
 */
class GuildMember
{
    public const LEADER_GRADE = 1;

    /**
     * @var Character $pid
     *
     * @ORM\Id()
     *
     * @ORM\OneToOne(targetEntity="App\Character\Entity\Character", inversedBy="guildMember")
     * @ORM\JoinColumn(name="pid", nullable=false)
     */
    private $character;

    /**
     * @var Guild $guild
     *
     * @ORM\ManyToOne(targetEntity="App\Guild\Entity\Guild", inversedBy="members")
     * @ORM\JoinColumn(name="guild_id", nullable=false)
     */
    private $guild;

    /**
     * @var int $grade
     *
     * @ORM\Column(name="grade", type="integer", nullable=false)
     */
    private $grade;

    public function getGuild(): Guild
    {
        return $this->guild;
    }

    /**
     * @return Character
     */
    public function getCharacter(): Character
    {
        return $this->character;
    }

    /**
     * @return int
     */
    public function getGrade(): int
    {
        return $this->grade;
    }

    /**
     * @return bool
     */
    public function isLeader(): bool
    {
        return $this->getGrade() === self::LEADER_GRADE;
    }
}
