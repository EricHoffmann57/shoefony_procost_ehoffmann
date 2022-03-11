<?php


namespace App\Controller\EmployeeControllers;

use App\Form\EmployeeType;
use App\Manager\EmployeeManager;
use App\Repository\Company\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeEditController extends AbstractController
{
    public function __construct(
        private EmployeeManager $employeeManager,
        private EmployeeRepository $employeeRepository
    ) {
    }
    #[Route('/company/form_employee/{id}', name: "edit_employee")]
    public function projectsCreatePage(int $id, Request $request): Response
    {
        $employee = $this->employeeRepository->find($id);
        if($employee === null)
        {
            throw new NotFoundHttpException('employee '.$id.' not found!');
        }
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid())
        {
            $this->addFlash('success', 'Employee has been successfully edited !');
            $this->employeeManager->save($employee);
            return $this->redirectToRoute('company_list_employees', [
            ]);
        }


        return $this->render('company/form_employee.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}