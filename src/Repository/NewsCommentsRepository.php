<?php

namespace App\Repository;

use App\Entity\NewsComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsComments>
 *
 * @method NewsComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsComments[]    findAll()
 * @method NewsComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsCommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsComments::class);
    }

//    /**
//     * @return NewsComments[] Returns an array of NewsComments objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NewsComments
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
