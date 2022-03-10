<?php

namespace App\DataFixtures;

use App\Entity\Job;
use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    private const DATA_JOBS = [
        ["developer web"],
        ["developer full stack"],
        ["ux designer"],
        ["SEO manager"],
        ["lead programmer"],
        ["analyst programmer"],
        ["developer back end"],
        ["software engineer"],
        ["mobile app developer"],
        ["computer system engineer"],
    ]
    ;

    private const DATA_EMPLOYEES = [

        [
            'firstName' => "Yu",
            'lastName' => "Narukami",
            "email" => "persona4ever@free.fr",
        ],
        [
            'firstName' => "Eren",
            'lastName' => "Jager",
            "email" => "titan.guy@asp.net",
        ],
        [
            'firstName' => "Yukiko",
            'lastName' => "Amagi",
            "email" => "cherryblossom@gamil.com",
        ],

        [
            'firstName' => "Hitoshi",
            'lastName' => "Sakimoto",
            "email" => "squix@aol.com",
        ],
        [
            'firstName' => "Sheena",
            'lastName' => "Brixton",
            "email" => "bluebox@sky.net",
        ],
        [
            'firstName' => "Okabe",
            'lastName' => "Rintaro",
            "email" => "gadget.lab01@yahoo.jp",
        ],

        [
            'firstName' => "Makise",
            'lastName' => "Kurisu",
            "email" => "christina@asahi.net",
        ],
        [
            'firstName' => "Mike",
            'lastName' => "Hammer",
            "email" => "mike.hammer@aol.com",
        ],

        [
            'firstName' => "Rick",
            'lastName' => "Hunter",
            "email" => "macross.sdf1@yahoo.co.jp",
        ]
    ]
    ;

    private const DATA_PROJECTS = [
        [
            'name' => "android app",
            'description' => "create a mobile application",
        ],
        [
            'name' => "angular project",
            'description' => "use framework angular exclusively",
        ],
        [
            'name' => "React Netflix",
            'description' => "clone netflix app",
        ],
        [
            'name' => "Symfony e-commerce",
            'description' => "Drupal is shit, use it!",
        ],
        [
            'name' => "webservice",
            'description' => "create a webservice for a client",
        ],
        [
            'name' => "website rework",
            'description' => "new ux design required",
        ],
        [
            'name' => "Ionic application",
            'description' => "use Ionic capacitor this time",
        ],
        [
            'name' => "Symfony rework",
            'description' => "convert CMS website to Symfony",
        ],
        [
            'name' => "whatever application",
            'description' => "do it quick!",
        ],
        [
            'name' => "another mobile app",
            'description' => "just to fill content",
        ],
    ]
    ;

    /**
     * @var ObjectManager
     */
    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
         //$employee = new Employee();
        $this->manager= $manager;
        $this->loadJobs();
        $this->loadEmployees();
        $this->loadProjects();
        $this->loadTodo();
        $manager->flush();
    }
    private function loadJobs(): void
    {
        foreach(self::DATA_JOBS as $key => [$name]){
            $job = (new Job())
                ->setName($name)
            ;
            $this->manager->persist($job);
            $this->addReference(Job::class .$key, $job);
        }
    }

    private function loadEmployees() : void
    {
        foreach(self::DATA_EMPLOYEES as $key => $employeeData){
            $date = new \DateTime ('now');
            $employee = (new Employee())
                ->setFirstName($employeeData['firstName'])
                ->setLastName($employeeData['lastName'])
                ->setEmail($employeeData['email'])
                ->setDailyCost(mt_rand(200, 1000))
                ->setHiringDate($date)
                ->setJob($this->getReference(Job::class .random_int(0, count(self::DATA_JOBS) - 1)))
            ;
            $this->manager->persist($employee);
            $this->addReference(Employee::class .$key, $employee);

            sleep(1);
        }
    }

    private function loadProjects() : void
    {

        foreach(self::DATA_PROJECTS as $key => $projectData){
            $date = new \DateTime('now');

            $project = (new Project())
                ->setName($projectData['name'])
                ->setDescription($projectData['description'])
                ->setSellingPrice(mt_rand(2500, 16000))
                ->setCreatedAt($date)
            ;
            $this->manager->persist($project);
            $this->addReference(Project::class .$key, $project);

            sleep(1);

        }
    }

    private function loadTodo() : void
    {
        for($i = 0; $i < 10; $i++){
            $date = new \DateTime('now');
            $todo = (new Todo())
                ->setProject($this->getReference(Project::class .random_int(0, count(self::DATA_PROJECTS) - 1)))
                ->setEmployee($this->getReference(Employee::class .random_int(0, count(self::DATA_EMPLOYEES) - 1)))
                ->setDevTime(random_int(1,9))
                ->setReleased($date)
            ;
            $this->manager->persist($todo);
            sleep(1);
        }
    }
}
