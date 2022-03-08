<?php


namespace App\Manager;


use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class ProjectManager
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }
    public function save(Project $project): void
    {
        $this->em->persist($project);
        $this->em->flush();

    }
}