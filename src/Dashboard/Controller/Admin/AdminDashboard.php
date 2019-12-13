<?php

namespace App\Dashboard\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Dashboard\Provider\AdminDashboardStatisticsProviderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminDashboard extends AbstractController
{
    protected $dashboardProvider;

    public function __construct(AdminDashboardStatisticsProviderInterface $dashboardProvider)
    {
        $this->dashboardProvider = $dashboardProvider;
    }

    /**
     * @Route("/", name="admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'statistics' => $this->dashboardProvider->getStatistics()
        ]);
    }
}
