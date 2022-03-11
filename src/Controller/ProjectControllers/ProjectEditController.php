<?php

namespace App\Controller\ProjectControllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\ProjectType;
use App\Manager\ProjectManager;
use App\Repository\Company\ProjectRepository;

class ProjectEditController extends AbstractController{

    public function __construct(
        private ProjectManager $projectManager,
        private ProjectRepository $projectRepository
    ) {
    }

    #[Route('/company/form_project/{id}', name: "edit_project")]
    public function projectsCreatePage(int $id, Request $request): Response
    {
        $project = $this->projectRepository->find($id);
        if($project == null)
        {
            throw new NotFoundHttpException('This page does not exists!');
        }
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){
            $this->addFlash('success', 'Project has been successfully edited !');
            $this->projectManager->save($project);
            return $this->redirectToRoute('company_list_projects', [
            ]);
        }


        return $this->render('company/form_job.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}