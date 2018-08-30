<?php

namespace App\Repository;

use App\Entity\MP3Metadata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MP3Metadata|null find($id, $lockMode = null, $lockVersion = null)
 * @method MP3Metadata|null findOneBy(array $criteria, array $orderBy = null)
 * @method MP3Metadata[]    findAll()
 * @method MP3Metadata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MP3MetadataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MP3Metadata::class);
    }

//    /**
//     * @return MP3Metadata[] Returns an array of MP3Metadata objects
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
    public function findOneBySomeField($value): ?MP3Metadata
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
