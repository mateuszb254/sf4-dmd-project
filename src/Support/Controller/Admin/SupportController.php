<?php

namespace App\Support\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\Support\Entity\Ticket;
use App\Support\Entity\TicketCategory;
use App\Support\Entity\TicketReply;
use App\Support\Form\Type\TicketAdminReplyType;
use App\Support\Form\Type\TicketCategoryType;
use App\Support\Repository\TicketCategoryRepository;
use App\Support\Repository\TicketRepository;
use App\Support\SupportEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @IsGranted("ROLE_USER")
 */
final class SupportController extends AbstractController
{
    /** @var TicketRepository $ticketRepository */
    private $ticketRepository;

    /** @var TicketCategoryRepository */
    private $ticketCategoryRepository;

    public function __construct(TicketRepository $ticketRepository, TicketCategoryRepository $categoryRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->ticketCategoryRepository = $categoryRepository;
    }

    /**
     * @Route("/{slug}", name="admin_support_tickets")
     */
    public function tickets(?TicketCategory $category = null, ?string $slug = null): Response
    {
        if (null === $category && null !== $slug) {
            throw new NotFoundHttpException('The category does not exist');
        }

        return $this->render('admin/support/index.html.twig', [
            'tickets' => $category ? $category->getTickets() : $this->ticketRepository->findAllTicketsWithLastReplyByCategory($category),
            'category' => $category
        ]);
    }

    /**
     * @Route("/{id}/ticket/", name="admin_support_ticket")
     */
    public function ticket(Request $request, Ticket $ticket): Response
    {
        $ticketReply = new TicketReply();

        $form = $this->createForm(TicketAdminReplyType::class, $ticketReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $ticket->addReply($ticketReply, Ticket::STATUS_ANSWERED);
            $ticketReply->setAuthor($this->getUser());

            $this->dispatchEvent($ticket, SupportEvent::SUPPORT_TICKET_REPLIED);

            $em->persist($ticket);
            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'support_ticket_admin_replied');
            return $this->redirectToRoute('admin_support_ticket', [
                'id' => $ticket->getId()
            ]);
        }

        return $this->render('admin/support/ticket.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/categories/list", name="admin_support_categories_list")
     */
    public function categoriesList(Request $request): Response
    {
        $ticketCategory = new TicketCategory();

        $form = $this->createForm(TicketCategoryType::class, $ticketCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($ticketCategory);
            $entityManager->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'support_category_added');
            return $this->redirectToRoute('admin_support_categories_list');
        }

        return $this->render('admin/support/category/index.html.twig', [
            'categories' => $this->ticketCategoryRepository->findAll(),
            'form' => $form->createView()
        ]);
    }
}
