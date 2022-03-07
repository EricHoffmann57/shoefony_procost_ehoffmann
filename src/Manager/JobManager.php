<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;

class JobManager
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }
    public function save(Job $job): void
    {
        $this->em->persist($job);
        $this->em->flush();

    }
}