<?php


namespace App\Controller\JobControllers;


use App\Entity\Job;
use App\Form\JobType;
use App\Manager\JobManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobFormController extends AbstractController
{
    public function __construct(
        private JobManager $jobManager,
    ) {
    }

    #[Route('/company/form_job', name: 'company_form_job', methods: ['GET','POST'])]
    public function formJob(Request $request): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash('success', 'New job successfully added !');
            $this->jobManager->save($job);

            return $this->redirectToRoute('company_list_jobs');
        }


        return $this->render('company/form_job.html.twig', [
            'form' => $form ->createView(),
        ]);
    }
}