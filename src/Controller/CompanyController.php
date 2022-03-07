<?php


namespace App\Controller;

use App\Repository\Company\EmployeeRepository;
use App\Repository\Company\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class CompanyController extends AbstractController
{
    public function __construct(
        private JobRepository $jobRepository,
        private EmployeeRepository $employeeRepository
    ) {
    }

    #[Route('/company/employees', name: 'company_list_employees')]
    public function listEmployees(): Response
    {


        $employees = $this->employeeRepository->findAll();
        return $this->render('company/list_employees.html.twig', [
            'employees' => $employees,
        ]);
    }
    #[Route('/company/employees/details{id}', name: 'company_details_employee', requirements: ['id' => '\d+'], methods: ['GET', 'POST'] )]
    public function detailEmployee(int $id): Response
    {
        $employee = $this->employeeRepository->find($id);
        if ($employee === null) {
            throw new NotFoundHttpException();
        }

        if ($id !== $employee->getId()) {
            return $this->redirectToRoute('company_details_employee', [
                'id' => $employee->getId(),
            ], Response::HTTP_MOVED_PERMANENTLY);
        }
            return $this->render('company/details_employee.html.twig', [
                //'id' => $id,
                'employee' => $employee,
            ]);

    }

    #[Route('/company/jobs', name: 'company_list_jobs')]
    public function listJobs(): Response
    {
        $jobs = $this->jobRepository->findAll();
        return $this->render('company/list_jobs.html.twig', [
            'jobs' => $jobs,
        ]);
    }

}