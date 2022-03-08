<?php

namespace App\Repository\Company;

use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Todo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Todo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Todo[]    findAll()
 * @method Todo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class TodoRepository extends ServiceEntityRepository
{
    private \DateTime $date;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct(
            $registry, Todo::class
        );
        $this->date = new \DateTime('now');
    }
    public function remove(Todo $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getEmployeeHasTodo(int $id): ?array
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->where('e.employee = :id' )
            ->setParameter('id', $id)
            ->orderBy('e.released', 'DESC')
            ;
        return $queryBuilder->getQuery()->getResult();
    }

    public function getEmployeeOnProject(int $id): ?array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.project = :id')
            ->setParameter('id', $id)
            ->orderBy('p.released', 'DESC')

        ;
        return $qb->getQuery()->getResult();
    }

    public function countEmployeesPerProject(int $id): ?array
    {
        $qb = $this->createQueryBuilder('e')
            ->select('COUNT(DISTINCT(e.employee)) as number')
            ->where('e.project = :id')
            ->setParameter('id', $id)
        ;
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            $e;
        }
    }

    public function costProductionSingleProject(int $id): ?array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('SUM(DISTINCT(em.cost)) as cost')
            ->leftJoin(Employee::class, 'em', 'WITH', 'em.id = p.employee')
            ->where('p.project = :id')
            ->setParameter('id', $id)
        ;
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            $e;
        }
    }

    public function countDevTimeAllProjects() : array
    {
        $qb = $this->createQueryBuilder('c')
            ->select("SUM(c.devTime) as time")
        ;
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            $e;
        }
    }

    public function countDevTimeOneProject(int $id): ?array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('SUM(p.devTime) as time')
            ->where('p.project = :id')
            ->setParameter('id', $id)
        ;
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            $e;
        }
    }

    public function devCostOneProject($id): array{
        $qb = $this->createQueryBuilder('p')
            ->select("SUM(employee.dailyCost * p.devTime) as cost")
            ->join(Employee::class, "employee")
            ->join(Project::class, "project")
            ->where('p.project = :id')
            ->andWhere("p.employee = employee.id")
            ->andWhere("project.id = p.project")
            ->setParameter('id', $id)
        ;
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            $e;
        }
    }

}