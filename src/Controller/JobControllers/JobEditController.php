<?php

namespace App\Controller\JobControllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\JobType;
use App\Manager\JobManager;
use App\Repository\Company\JobRepository;

class JobEditController extends AbstractController{

    public function __construct(
        private JobManager $jobManager,
        private JobRepository $jobRepository
    ) {
    }

    #[Route('/company/form_job/{id}', name: "edit_job")]
    public function projectsCreatePage(int $id, Request $request): Response
    {
        $job = $this->jobRepository->find($id);
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){
            $this->addFlash('success', 'Job has been successfully edited !');
            $this->jobManager->save($job);
            return $this->redirectToRoute('company_list_jobs', [
            ]);
        }


        return $this->render('company/form_job.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}