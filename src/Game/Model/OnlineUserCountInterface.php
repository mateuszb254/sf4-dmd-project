<?php

namespace App\Game\Model;

interface OnlineUserCountInterface
{
    public function getAmountOfShinsooPlayers(): int;

    public function getAmountOfJinnoPlayers(): int;

    public function getAmountOfChunjoPlayers(): int;

    public function getAmountOfPlayers(): int;
}
