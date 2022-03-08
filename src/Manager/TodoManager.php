<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;


final class TodoManager
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function save(Todo $todo): void
    {
        $this->em->persist($todo);
        $this->em->flush();
    }
}