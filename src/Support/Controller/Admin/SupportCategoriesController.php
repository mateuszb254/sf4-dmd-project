<?php

namespace App\Support\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Support\Entity\TicketCategory;
use App\Support\Repository\TicketCategoryRepository;

class SupportCategoriesController extends AbstractController
{
    protected $ticketCategoryRepository;

    public function __construct(TicketCategoryRepository $ticketCategoryRepository)
    {
        $this->ticketCategoryRepository = $ticketCategoryRepository;
    }

    public function renderCategoriesNavigation(?TicketCategory $currentCategory)
    {
        return $this->render('admin/support/partials/_categories_navigation.html.twig', [
            'currentCategory' => $currentCategory,
            'categoriesWithAmount' => $this->ticketCategoryRepository->findAllWithAmountOfUnansweredTickets()
        ]);
    }
}
