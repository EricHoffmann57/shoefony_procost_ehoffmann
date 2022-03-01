<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CompanyController extends AbstractController
{
    public function __construct(

    ) {
    }

    #[Route('/company/employees', name: 'company_list_employees')]
    public function listEmployees(): Response
    {


        $employees = [];
        return $this->render('company/list_employees.html.twig', [
            'employees' => $employees,
        ]);
    }
    #[Route('/company/employees/details', name: 'company_details_employee')]
    public function detailEmployee(): Response
    {
            return $this->render('company/details_employee.html.twig', [
                //'id' => $id,
            ]);

    }
}