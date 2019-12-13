<?php

namespace App\Terms\Controller;

use App\Core\Controller\AbstractController;
use App\Terms\Repository\TermsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class TermsController extends AbstractController
{
    /** @var TermsRepository $repository */
    private $repository;

    public function __construct(TermsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/terms", name="terms")
     */
    public function terms(): Response
    {
        return $this->render('user/terms/terms.html.twig', [
            'terms' => $this->repository->findLatest()
        ]);
    }
}
