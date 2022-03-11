<?php


namespace App\Controller;


use App\Entity\Todo;
use App\Form\DelayingProjectType;
use App\Form\DelProjectType;
use App\Form\EndProjectType;
use App\Form\TodoType;
use App\Manager\JobManager;
use App\Manager\TodoManager;
use App\Manager\ProjectManager;
use App\Repository\Company\EmployeeRepository;
use App\Repository\Company\JobRepository;
use App\Repository\Company\ProjectRepository;
use App\Repository\Company\TodoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;



class CompanyController extends AbstractController
{
    private \DateTime $date;

    public function __construct(
        private JobRepository $jobRepository,
        private EmployeeRepository $employeeRepository,
        private ProjectRepository $projectRepository,
        private TodoRepository $todoRepository,
        private ProjectManager $projectManager,
        private TodoManager $todoManager,
        private JobManager $jobManager,
    ) {
        $this->date = new \DateTime('now');
    }

    // employees list and details per employee
    #[Route('/company/employees', name: 'company_list_employees')]
    public function listEmployees(PaginatorInterface $paginator, Request $request): Response
    {
        $data = $this->employeeRepository->findBy([], ['hiringDate' => 'DESC']);
        $employees = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),10
        );

        return $this->render('company/list_employees.html.twig', [
            'employees' => $employees,
        ]);
    }
    #[Route('/company/employees/details{id}', name: 'company_details_employee', requirements: ['id' => '\d+'], methods: ['GET', 'POST'] )]
    public function detailEmployee(int $id, Request $request): Response
    {
        $employee = $this->employeeRepository->find($id);

        if($employee === null)
        {
            throw new NotFoundHttpException('employee '.$id.' not found!');
        }
        $employeesOnTodo = $this->todoRepository->getEmployeeHasTodo($id);
        $allTodos = $employeesOnTodo;
        $todo = new Todo();
        $todo->setEmployee($employee);

        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid())
        {

            if($todo->getProject()->getReleaseDate() != null)
            {
                $this->addFlash('danger', 'This project is definitely released');
            }else{
                $this->addFlash('success', 'You have successfully added time');
                $this->todoManager->save($todo);
            }

        }

            return $this->render('company/details_employee.html.twig', [
                //'id' => $id,
                'employee' => $employee,
                'employeesOnTodo' => $employeesOnTodo,
                'form' => $form->createView(),
                'allTodos' => $allTodos??null
            ]);

    }
    // jobs list
    #[Route('/company/jobs', name: 'company_list_jobs' )]
    public function listJobs(PaginatorInterface $paginator,Request $request): Response
    {
        $data = $this->jobRepository->findBy([], ['id' => 'DESC']);;
        $jobs = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),10
        );

            $deleteJob = $this->jobRepository->deleteJob();

            return $this->render('company/list_jobs.html.twig', [
                'jobs' => $jobs,
                'deleteJob' => $deleteJob,
            ]);

    }

    // projects list and details per project
    #[Route('/company/projects', name: 'company_list_projects')]
    public function listProjects(PaginatorInterface $paginator, Request $request): Response
    {
        $data = $this->projectRepository->findBy([], ['created_at' => 'DESC']);
        $projects = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),10
        );
        return $this->render('company/list_projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/company/projects/details{id}', name: 'company_details_project', requirements: ['id' => '\d+'], methods: ['GET', 'POST'] )]
    public function detailProject(int $id, Request $request ): Response
    {
        $project = $this->projectRepository->find($id);
        if($project === null)
        {
            throw new NotFoundHttpException('project '.$id.' not found!');
        }
        //End a project by deleting or adding a release status

        $deleteProject = $this->createForm(DelProjectType::class, $project);
        $deleteProject->handleRequest($request);
        if($deleteProject->isSubmitted()  && $deleteProject->isValid())
        {
            $this->addFlash('success', 'Project has been successfully deleted');
            $this->projectRepository->remove($project);
            return $this->redirectToRoute('company_list_projects', [
            ]);
        }

        $releaseProject = $this->createForm(EndProjectType::class, $project);
        $releaseProject->handleRequest($request);
        if($releaseProject->isSubmitted()  && $releaseProject->isValid())
        {
            $project->setReleaseDate($this->date);
            $this->projectManager->save($project);
            $this->addFlash('success', 'Project release is done');
        }

        // set additional time for a project
        $todo = new Todo();
        $todo->setProject($project);

        $delayingProject = $this->createForm(DelayingProjectType::class, $todo);
        $delayingProject->handleRequest($request);

        if($delayingProject->isSubmitted()  && $delayingProject->isValid())
        {
            if($todo->getProject()->getReleaseDate() != null)
            {
                $this->addFlash('danger', 'Project has been definitely released');
            }else{
                $this->addFlash('success', 'Another employee has joined project!');
                $this->todoManager->save($todo);
            }
        }
        $employeesOnProject = $this->todoRepository->getEmployeeOnProject($id);
        $countEmployeesOnTodo = $this->todoRepository->countEmployeesPerProject($id);
        $countDevTimeOneProject = $this->todoRepository->countDevTimeOneProject($id);
        $devCostOneProject = $this->todoRepository->devCostOneProject($id);
        $allTodos = $employeesOnProject;


        return $this->render('company/details_project.html.twig', [
            //'id' => $id,
            'project' => $project,
            'deleteProject' => $deleteProject->createView(),
            'releaseProject' => $releaseProject->createView(),
            'delayingProject' => $delayingProject->createView(),
            'employeesOnTodo' => $employeesOnProject,
            'countEmployeesOnTodo' => $countEmployeesOnTodo,
            'countDevTimeOneProject' => $countDevTimeOneProject,
            'devCostOneProject' => $devCostOneProject,
            'allTodos'   => $allTodos??null
        ]);
    }
}