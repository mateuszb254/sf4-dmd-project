<?php

namespace App\Article\Controller\Admin;

use App\Article\ArticleEvents;
use App\Article\Entity\Article;
use App\Article\Event\ArticleEvent;
use App\Article\Form\ArticleType;
use App\Article\Repository\ArticleRepositoryInterface;
use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\User\Permissions;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted(Permissions::ARTICLE_CAN_BROWSE_SECTION)
 */
final class ArticleController extends AbstractController
{
    /** @var ArticleRepositoryInterface $repository */
    private $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/{page}", defaults={"page" : 1}, requirements={"page" : "\d+"}, name="admin_article_index")
     */
    public function index(Request $request, int $page = 1): Response
    {
        return $this->render('admin/article/index.html.twig', [
            'pagination' => $this->articleRepository->findLatestPaginated(
                $page, null, Article::PER_PAGE_ADMIN
            )
        ]);
    }

    /**
     * @IsGranted(Permissions::ARTICLE_CAN_ADD)
     * @Route("/new", name="admin_article_new")
     */
    public function new(Request $request): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $article->setAuthor($this->getUser());
            $em->persist($article);
            $em->flush();

            if ($article->getStatus() === Article::STATUS_PUBLISHED) {
                $this->dispatchEvent(new ArticleEvent($article), ArticleEvents::ARTICLE_PUBLISHED);
            }

            $this->addFlash(FlashMessageTypes::SUCCESS, 'article_edit_success');
            return $this->redirectToRoute('admin_article_index');
        }
        return $this->render('admin/article/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted(Permissions::ARTICLE_CAN_EDIT)
     * @Route("/edit/{id}", requirements={"id" : "\d+"}, name="admin_article_edit")
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'article_edit_success');
            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('admin/article/edit.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @IsGranted(Permissions::ARTICLE_CAN_DELETE)
     * @Route("/delete/{id}", requirements={"id" : "\d+"}, name="admin_article_delete")
     */
    public function delete(Request $request, Article $article)
    {
        if ($this->isCsrfTokenValid('delete', $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($article);
            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'article_deleted');
        }

        return $this->redirectToRoute('admin_article_index');
    }
}
