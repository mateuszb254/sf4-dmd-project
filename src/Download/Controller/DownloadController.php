<?php

namespace App\Download\Controller;

use App\Core\Controller\AbstractController;
use App\Download\Repository\DownloadRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    /** @var DownloadRepository $repository */
    private $repository;

    public function __construct(DownloadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/download", name="download_mirrors")
     */
    public function mirrors(Request $request): Response
    {
        return $this->render('user/download/mirrors.html.twig', [
            'mirrors' => $this->repository->findAll()
        ]);
    }
}
