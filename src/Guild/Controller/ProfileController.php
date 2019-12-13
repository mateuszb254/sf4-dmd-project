<?php

namespace App\Guild\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\Guild\Entity\Guild;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

final class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{name}", name="guild_profile")
     */
    public function profile(?Guild $guild): Response
    {
        if (null === $guild) {
            $this->addFlash(FlashMessageTypes::FAILURE, 'guild_not_found');
            return $this->redirectToRoute('ranking_guilds');
        }

        return $this->render('user/guild/profile.html.twig', [
            'guild' => $guild
        ]);
    }
}
