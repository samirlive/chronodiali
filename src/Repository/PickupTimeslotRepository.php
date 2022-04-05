<?php

namespace App\Repository;

use App\Entity\PickupTimeslot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PickupTimeslot|null find($id, $lockMode = null, $lockVersion = null)
 * @method PickupTimeslot|null findOneBy(array $criteria, array $orderBy = null)
 * @method PickupTimeslot[]    findAll()
 * @method PickupTimeslot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PickupTimeslotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PickupTimeslot::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PickupTimeslot $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PickupTimeslot $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PickupTimeslot[] Returns an array of PickupTimeslot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PickupTimeslot
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
