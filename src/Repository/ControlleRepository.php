<?php

namespace App\Repository;

use App\Entity\Controlle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Controlle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Controlle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Controlle[]    findAll()
 * @method Controlle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControlleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Controlle::class);
    }

//    /**
//     * @return Controlle[] Returns an array of Controlle objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Controlle
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
