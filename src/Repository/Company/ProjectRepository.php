<?php

namespace App\Repository\Company;

use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ProjectRepository extends ServiceEntityRepository
{
    private \DateTime $date;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct(
            $registry, Project::class
        );
        $this->date = new \DateTime('now');
    }
    public function remove(Project $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function getPendingProjects(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('COUNT(p.id) as projects')
            ->where("p.releaseDate IS NULL ")
        ;
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            $e;
        }
    }

    public function getReleasedProjects(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('COUNT(p.id) as projects')
            ->where("p.releaseDate IS NOT NULL ")
        ;
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            $e;
        }
    }

    public function findLastProjects(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.id, SUM(employee.dailyCost * todo.devTime) as cost, p.name,p.created_at,p.sellingPrice,p.releaseDate')
            ->join(Employee::class, "employee")
            ->join(Todo::class, "todo")
            ->where('p.id = todo.project')
            ->andWhere("employee.id = todo.employee")
            ->groupBy('p.name')
            ->orderBy('p.created_at', 'DESC')
            ->setMaxResults(5)
        ;

        return $qb->getQuery()->getResult();
    }

    public function countSellingAllProjects() : array
    {
        $qb = $this->createQueryBuilder('s')
            ->select("SUM(s.sellingPrice) as sell")
        ;
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            $e;
        }
    }

    public function countDevCostAllProjectsSold(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.id, SUM(employee.dailyCost * todo.devTime) as cost, p.name,p.created_at,p.sellingPrice,p.releaseDate')
            ->join(Employee::class, "employee")
            ->join(Todo::class, "todo")
            ->where('p.id = todo.project')
            ->andWhere("employee.id = todo.employee")
            ->andWhere('p.releaseDate IS NOT NULL')
            ->groupBy('p.name')
            ->orderBy('p.created_at', 'DESC')
            ->setMaxResults(5)
        ;

        return $qb->getQuery()->getResult();
    }

}