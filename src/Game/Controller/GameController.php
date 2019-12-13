<?php

namespace App\Game\Controller;

use App\Core\Controller\AbstractController;
use App\Game\Client\GameClientInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

final class GameController extends AbstractController
{
    /**
     * @var GameClientInterface $gameClient
     */
    private $client;

    public function __construct(GameClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/server-status", name="game_api_server_status")
     */
    public function serverStatus()
    {
        return $this->render('user/game/server_status.html.twig', [
            'isServerUp' => $this->client->isServerUp()
        ]);
    }
}
