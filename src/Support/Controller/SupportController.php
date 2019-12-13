<?php

namespace App\Support\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\Support\Entity\Ticket;
use App\Support\Entity\TicketReply;
use App\Support\Form\Type\TicketReplyType;
use App\Support\Form\Type\TicketType;
use App\Support\Repository\TicketRepository;
use App\Support\SupportEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class SupportController extends AbstractController
{
    /** @var TicketRepository $repository */
    private $repository;

    public function __construct(TicketRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="support_index")
     */
    public function index(Request $request): Response
    {
        return $this->render('user/support/base.html.twig');
    }

    /**
     * @Route("/list/{page}", name="support_ticket_list")
     */
    public function list(Request $index, int $page = 1): Response
    {
        return $this->render('user/support/list.html.twig', [
            'pagination' => $this->repository->findAllPaginatedByUser($this->getUser(), $page)
        ]);
    }

    /**
     * @Route("/new", name="support_ticket_new")
     */
    public function new(Request $request): Response
    {
        $ticket = new Ticket();

        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $ticket->setAuthor($this->getUser());

            $em->persist($ticket);
            $em->flush();

            $this->dispatchEvent($ticket, SupportEvent::SUPPORT_TICKET_CREATED);
            $this->addFlash(FlashMessageTypes::SUCCESS, 'support_ticket_send');
            return $this->redirectToRoute('support_ticket_new');
        }

        return $this->render('user/support/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Security("ticket.getAuthor() == user")
     *
     * @Route("/ticket/{id}", requirements={"id" : "\d+"}, name="support_ticket_show")
     */
    public function show(Request $request, Ticket $ticket)
    {
        $ticketReply = new TicketReply();

        $form = $this->createForm(TicketReplyType::class, $ticketReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $ticket->addReply($ticketReply);
            $ticketReply->setAuthor($this->getUser());

            $this->dispatchEvent($ticket, SupportEvent::SUPPORT_TICKET_REPLIED);

            $em->persist($ticketReply);
            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'support_ticket_send');
            return $this->redirectToRoute('support_ticket_show', [
                'id' => $ticket->getId()
            ]);
        }


        return $this->render('user/support/ticket.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView()
        ]);
    }
}
