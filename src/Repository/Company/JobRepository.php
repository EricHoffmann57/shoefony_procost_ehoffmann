<?php


namespace App\Repository\Company;


use App\Entity\Employee;
use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct(
            $registry, Job::class
        );
    }

    /**
     * @param Job $entity
     * @param bool $flush
     */
    public function add(Job $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Job $entity
     * @param bool $flush
     */
    public function remove(Job $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function deleteJob(): array
    {
        $qb = $this->createQueryBuilder('j')
            ->select('j.id, j.name, employee.id as employeeID')
            ->join(Employee::class,'employee')
            ->where('j.id = employee.job')
        ;
        return $qb->getQuery()->getResult();
    }
}