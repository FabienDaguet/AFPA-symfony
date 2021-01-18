<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    //Requette faite par le query builder
    public function findLastNews(int $nb = 5)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.status = :status')
            ->setParameter('status', "PUBLISHED")
            ->orderBy('n.createdAt', 'DESC')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult();
    }

    //requete faite en sql
    public function findOldNews(int $nb = 5): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT n.id, n.title, n.createdAt, n.imgUrl
            FROM App\Entity\News n
            WHERE n.status = :status
            ORDER BY n.createdAt ASC'
        )->setParameter('status', "PUBLISHED")
        ->setMaxResults($nb);
        // returns an array of Product objects
        return $query->getResult();
    }

    // /**
    //  * @return News[] Returns an array of News objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
