<?php

namespace App\Character\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="character_index")
 * @ORM\Entity()
 */
class CharacterIndex
{
    /**
     * @var integer $id
     *
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\User\Entity\User", inversedBy="charactersIndex")
     * @ORM\JoinColumn(name="id", nullable=false)
     */
    private $id;

    /**
     * @var integer $character1
     *
     * @ORM\Column(name="pid1", type="integer", options={"default" : 0} ,nullable=false)
     */
    private $character1 = 0;

    /**
     * @var integer $character2
     *
     * @ORM\Column(name="pid2", type="integer", options={"default" : 0} ,nullable=false)
     */
    private $character2 = 0;

    /**
     * @var integer $character3
     *
     * @ORM\Column(name="pid3", type="integer", options={"default" : 0} ,nullable=false)
     */
    private $character3 = 0;

    /**
     * @var integer $character4
     *
     * @ORM\Column(name="pid4", type="integer", options={"default" : 0} ,nullable=false)
     */
    private $character4 = 0;

    /**
     * @var integer $character5
     *
     * @ORM\Column(name="pid5", type="integer", options={"default" : 0} ,nullable=false)
     */
    private $character5 = 0;

    /**
     * @var integer $empire
     *
     * @ORM\Column(name="empire", type="integer", options={"default" : 0} ,nullable=false)
     */
    private $empire;

    public function getEmpire()
    {
        return $this->empire;
    }
}
