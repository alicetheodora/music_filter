<?php

namespace App\Repository;

use App\Entity\MP3Blob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MP3Blob|null find($id, $lockMode = null, $lockVersion = null)
 * @method MP3Blob|null findOneBy(array $criteria, array $orderBy = null)
 * @method MP3Blob[]    findAll()
 * @method MP3Blob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MP3BlobRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MP3Blob::class);
    }

//    /**
//     * @return MP3Blob[] Returns an array of MP3Blob objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MP3Blob
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
