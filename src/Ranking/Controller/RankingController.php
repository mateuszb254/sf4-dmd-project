<?php

namespace App\Ranking\Controller;

use App\Character\Repository\CharacterRepository;
use App\Core\Controller\AbstractController;
use App\Guild\Repository\GuildRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RankingController extends AbstractController
{
    /**
     * @var CharacterRepository $repository
     */
    private $characterRepository;

    /**
     * @var CharacterRepository $repository
     */
    private $guildRepository;

    public function __construct(CharacterRepository $characterRepository, GuildRepository $guildRepository)
    {
        $this->characterRepository = $characterRepository;
        $this->guildRepository = $guildRepository;
    }

    /**
     * @Route("/characters/{page}", options={"page": 0}, name="ranking_characters")
     */
    public function charactersRanking(Request $request, int $page = 1): Response
    {
        if ($playerName = $request->get('search')) {
            return $this->redirectToRoute('character_profile', [
                'name' => $playerName
            ]);
        }
        return $this->render('user/ranking/ranking_characters.html.twig', [
            'pagination' => $this->characterRepository->findLatestPaginated($page)
        ]);
    }

    /**
     * @Route("/guilds/{page}", options={"page": 0}, name="ranking_guilds")
     */
    public function guildsRanking(Request $request, int $page = 1): Response
    {
        if ($guildName = $request->get('search')) {
            return $this->redirectToRoute('guild_profile', [
               'name' => $guildName
            ]);
        }

        return $this->render('user/ranking/ranking_guilds.html.twig', [
            'pagination' => $this->guildRepository->findLatestPaginated($page)
        ]);
    }

    /**
     * @Route("/sidebar", name="character_ranking_sidebar")
     */
    public function sidebarRanking(): Response
    {
        return $this->render('user/ranking/ranking_sidebar.html.twig', [
            'characters' => $this->characterRepository->findTopCharacters(),
            'guilds' => $this->guildRepository->findTopGuilds()
        ]);
    }
}
