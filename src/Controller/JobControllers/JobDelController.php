<?php

namespace App\Controller\JobControllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\JobType;
use App\Manager\JobManager;
use App\Repository\Company\JobRepository;

class JobDelController extends AbstractController{

    public function __construct(
        private JobManager $jobManager,
        private JobRepository $jobRepository
    ) {
    }

    #[Route('/company/form_job_delete/{id}', name: "delete_job")]
    public function projectsCreatePage(int $id, Request $request): Response
    {
        $job = $this->jobRepository->find($id);
        if($job === null)
        {
            throw new NotFoundHttpException('job '.$id.' not found!');
        }
        $deleteJob =$this->jobRepository->deleteJob();
        $delJob = $this->createForm(JobType::class, $job);
        $delJob->handleRequest($request);

        if($delJob->isSubmitted()  && $delJob->isValid())
        {
            $this->addFlash('success', 'Job has been successfully deleted !');
            $this->jobRepository->remove($job);
            return $this->redirectToRoute('company_list_jobs', [
            ]);
        }


        return $this->render('company/form_job_delete.html.twig', [
            'delJob' => $delJob->createView(),
            'deleteJob' => $deleteJob,
        ]);
    }
}