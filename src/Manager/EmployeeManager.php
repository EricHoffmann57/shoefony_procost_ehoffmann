<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeManager
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function save(Employee $employee): void
    {
        $this->em->persist($employee);
        $this->em->flush();

    }
}