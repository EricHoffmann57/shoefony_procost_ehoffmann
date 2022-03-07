<?php

declare(strict_types=1);

namespace App\Controller\EmployeeControllers;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Manager\EmployeeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EmployeeFormController extends AbstractController
{
    public function __construct(
        private EmployeeManager $employeeManager,
    ) {
    }

    #[Route('/company/form_employee', name: 'company_form_employee', methods: ['GET','POST'])]
    public function formEmployee(Request $request): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'New employee successfully added !');
            $this->employeeManager->save($employee);

            return $this->redirectToRoute('company_list_employees');
        }


        return $this->render('company/form_employee.html.twig', [
            'form' => $form ->createView(),
        ]);
    }
}