<?php

namespace App\Repository;

use App\Entity\MP3File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MP3File|null find($id, $lockMode = null, $lockVersion = null)
 * @method MP3File|null findOneBy(array $criteria, array $orderBy = null)
 * @method MP3File[]    findAll()
 * @method MP3File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MP3FileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MP3File::class);
    }

    public function findOneByIdJoinedToCategory()
    {
        return $this->createQueryBuilder('m')
            ->addSelect('md','mb')
            ->innerJoin('m.mp3metadata','md')
            ->innerJoin('m.mp3blob','mb')
            ->getQuery()
            ->getResult();

    }

    public function searchRow($name)
    {
        return $this->createQueryBuilder('m')
            ->addSelect('md','mb')
            ->innerJoin('m.mp3metadata','md')
            ->innerJoin('m.mp3blob','mb')
            ->andWhere('m.basename = :name')
            ->setParameter('name',$name)
            ->getQuery()
            ->getResult();

    }

    /*
    public function findOneBySomeField($value): ?MP3File
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
