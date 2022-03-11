<?php

namespace App\Controller;

use App\Repository\Company\EmployeeRepository;
use App\Repository\Company\ProjectRepository;
use App\Repository\Company\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


final class MainController extends AbstractController
{


    private \DateTime $date;

    public function __construct(
        private EmployeeRepository $employeeRepository,
        private ProjectRepository $projectRepository,
        private TodoRepository $todoRepository,
    ) {
        $this->date = new \DateTime('now');
    }

    #[Route('/', name: 'main_homepage', methods: ['GET'])]
    public function homepage(): Response
    {
        $countEmployees = $this->employeeRepository->countEmployees();
        $getPendingProjects = $this->projectRepository->getPendingProjects();
        $getReleasedProjects = $this->projectRepository->getReleasedProjects();
        $countDevTimeAllProjects = $this->todoRepository-> countDevTimeAllProjects();
        $lastProjects = $this->projectRepository->findLastProjects();
        $soldProjects = $this->projectRepository->countDevCostAllProjectsSold();
        $totalSell = $this->projectRepository->countSellingAllProjects();
        $lastDevTimes = $this->employeeRepository->getLastDevTimes();
        $bestWorker = $this->employeeRepository->bestWorker();

        return $this->render('main/index.html.twig', [
           'countEmployees' => $countEmployees,
           'pending' => $getPendingProjects,
           'released' => $getReleasedProjects,
            'allDevTime' => $countDevTimeAllProjects,
            'lastProjects' => $lastProjects,
             'totalSold' => $soldProjects,
            'totalSell' => $totalSell,
            'lastDevTimes' => $lastDevTimes,
            'bestWorker' => $bestWorker,
        ]);
    }
}