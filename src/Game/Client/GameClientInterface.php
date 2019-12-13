<?php

namespace App\Game\Client;

use App\Game\Model\OnlineUserCountInterface;

interface GameClientInterface
{
    public const EVENT_EXP = 0;
    public const EVENT_DROP = 1;
    public const EVENT_MONEY = 2;

    /**
     * @return OnlineUserCountInterface
     */
    public function getOnlineUsersCount(): OnlineUserCountInterface;

    public function disconnectUser(string $login);

    /**
     * @param int $empire
     * @param string $type GameClientInterface::EVENT_*
     * @param int $value
     * @param int $duration time in seconds
     *
     * @return mixed
     */
    public function setEmpireEvent(int $empire, string $type, int $value, int $duration);

    /**
     * @return mixed
     */
    public function shutdownServer();


    /**
     * It checks if game is available for users
     *
     * @return bool
     */
    public function isServerUp(): bool;

    /**
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public function setEvent(string $name, string $value);
}
