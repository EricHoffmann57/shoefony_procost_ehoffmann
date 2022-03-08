<?php


namespace App\Controller\ProjectControllers;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Manager\ProjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectFormController extends AbstractController
{

    public function __construct(
        private ProjectManager $projectManager,
    ) {
    }

    #[Route('/company/form_project', name: 'company_form_project', methods: ['GET','POST'])]
    public function formProject(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'New project successfully added !');
            $this->projectManager->save($project);

            return $this->redirectToRoute('company_list_projects');
        }


        return $this->render('company/form_project.html.twig', [
            'form' => $form ->createView(),
        ]);
    }
}