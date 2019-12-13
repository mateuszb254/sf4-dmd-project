<?php

namespace App\Game\Client;

use App\Game\Model\GameApiResponse;
use App\Game\Model\GameApiResponseInterface;
use App\Game\Model\OnlineUserCount;
use App\Game\Model\OnlineUserCountInterface;

class GameClient implements GameClientInterface
{
    /** @var string $host */
    protected $host;

    /** @var int $port */
    protected $port;

    /** @var string $password */
    protected $password;

    public function __construct(string $host, int $port, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
    }

    public function setEmpireEvent(int $empire, string $type, int $value, int $duration)
    {
        // TODO: Implement setEmpireEvent() method.
    }

    public function getOnlineUsersCount(): OnlineUserCountInterface
    {
        $response = $this->sendRequest('USER_COUNT');
        $usersOnline = $response->getData();

        return new OnlineUserCount($usersOnline[1], $usersOnline[2], $usersOnline[3]);
    }

    public function shutdownServer()
    {
        $this->sendRequest('SHUTDOWN');
    }

    public function disconnectUser(string $login)
    {
        $this->sendRequest('DC', $login);
    }


    public function isServerUp(): bool
    {
        $response = $this->sendRequest('IS_SERVER_UP');

        return $response->getData()[0] === 'YES';
    }

    public function setEvent(string $name, string $value)
    {
        // TODO: Implement setEvent() method.
    }

    /**
     * @param string $key
     * @param string|null $message
     * @return GameApiResponseInterface game api response
     */
    protected function sendRequest(string $key, ?string $message = null): GameApiResponseInterface
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        try {
            \socket_connect($socket, $this->host, $this->port);

            $query = "\x40'.$this->password.'\x0A" . "\x40" . $key . ($message ?? "") . "\x0A";

            \socket_write($socket, $query, strlen($query));
            \socket_recv($socket, $response, 5056, 0);
            \socket_close($socket);

            $response = preg_split('/[\s\n]/', substr(trim($response), 15));
        } catch (\ErrorException $exception) {
            $response[] = 'Connection error';
            $response[] = $exception->getMessage();
        }

        return new GameApiResponse(array_shift($response), $response);
    }
}
