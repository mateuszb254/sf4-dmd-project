<?php

namespace App\Article\Controller;

use App\Article\Entity\Article;
use App\Article\Repository\ArticleRepositoryInterface;
use App\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /** @var ArticleRepositoryInterface $repository */
    private $repository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->repository = $articleRepository;
    }

    /**
     * @Route("/", name="homepage")
     * @Route("/article/{page}", requirements={"page" : "\d+"}, defaults={"page" : 1}, name="articles")
     */
    public function index(Request $request, int $page = 1): Response
    {
        return $this->render('user/homepage.html.twig', [
            'pagination' => $this->repository->findLatestPaginated(
                $page, Article::STATUS_PUBLISHED, Article::PER_PAGE
            )
        ]);
    }
}
