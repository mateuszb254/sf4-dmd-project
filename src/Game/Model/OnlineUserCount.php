<?php

namespace App\Game\Model;

class OnlineUserCount implements OnlineUserCountInterface
{
    private $shinsoo;
    private $chunjo;
    private $jinno;

    public function __construct(int $shinsoo, int $chunjo, int $jinno)
    {
        $this->shinsoo = $shinsoo;
        $this->chunjo = $chunjo;
        $this->jinno = $jinno;
    }

    public function getAmountOfShinsooPlayers(): int
    {
        return $this->shinsoo;
    }

    public function getAmountOfChunjoPlayers(): int
    {
        return $this->chunjo;
    }

    public function getAmountOfJinnoPlayers(): int
    {
        return $this->jinno;
    }

    public function getAmountOfPlayers(): int
    {
        return $this->getAmountOfShinsooPlayers() + $this->getAmountOfJinnoPlayers() + $this->getAmountOfPlayers();
    }
}
