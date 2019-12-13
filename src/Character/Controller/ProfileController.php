<?php

namespace App\Character\Controller;

use App\Character\Entity\Character;
use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

final class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{name}", name="character_profile")
     * @Entity("character", expr="repository.findByName(name)")
     */
    public function profile(?Character $character): Response
    {
        if (null === $character) {
            $this->addFlash(FlashMessageTypes::FAILURE, 'character_not_found');
            return $this->redirectToRoute('ranking_characters');
        }

        return $this->render('user/character/profile.html.twig', [
            'character' => $character
        ]);
    }
}
