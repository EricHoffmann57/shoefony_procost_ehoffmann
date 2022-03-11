<?php

namespace App\Repository\Company;

use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct(
            $registry, Employee::class
        );
    }

    /**
     * @param Employee $entity
     * @param bool $flush
     */
    public function add(Employee $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush)
        {
            $this->_em->flush();
        }
    }

    public function remove(Employee $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush)
        {
            $this->_em->flush();
        }
    }

    public function countEmployees(): array
    {
        $qb = $this->createQueryBuilder('e')
            ->select('COUNT(e.id) as count');
            return $qb->getQuery()->getOneOrNullResult();
    }

    public function getLastDevTimes(): array
    {
        $qb = $this->createQueryBuilder('e')
            ->select("e.id, e.lastName, e.firstName, project.id as projectID, project.name,project.created_at,todo.devTime")
            ->join(Project::class, 'project')
            ->join(Todo::class, 'todo')
            ->join(Employee::class, 'employee')
            ->where("employee.id = todo.employee")
            ->andWhere('e.id = todo.employee')
            ->andWhere('todo.project = project.id')
            ->orderBy('todo.id', 'DESC')
            ->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }

    public function bestWorker()
    {
        $qb = $this->createQueryBuilder('e')
            ->select("e.id, e.lastName, e.firstName, e.hiringDate, MAX(e.dailyCost * todo.devTime) as maxCost")
            ->join(Todo::class, 'todo')
            ->where("e.id = todo.employee ")
            ->orderBy('maxCost', 'DESC')
        ;
        return $qb->getQuery()->getResult();
    }

}
