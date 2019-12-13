<?php

namespace App\Game\Model;

interface GameApiResponseInterface
{
    public function getStatus(): string;

    public function getData(): ?array;
}
