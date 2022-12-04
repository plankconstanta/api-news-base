<?php

namespace App\Repository;

use App\Entity\News;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
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

    public function save(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return News[] Returns an array of News objects
    */
    public function findPaginatedByParams(int $pageSize, int $page, DateTimeImmutable $dateFrom = null, array $tagIds = []): Paginator
    {
        $dateNow = new DateTimeImmutable('now');

        $queryBuilder = $this->createQueryBuilder('n')
            ->andWhere('n.published_at < :val1')
            ->setParameter('val1', $dateNow)
            ->orderBy('n.published_at', 'DESC');

        if ($dateFrom instanceof DateTimeImmutable) {
            $queryBuilder->andWhere('n.published_at > :val2')
                ->setParameter('val2', $dateFrom);
        }

        if (is_array($tagIds) && !empty($tagIds)) {
            $queryBuilder->leftJoin('n.tags', 't')
            ->andWhere($queryBuilder->expr()->in('t.id', $tagIds));
        }

        $paginator = new Paginator($queryBuilder->getQuery());

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * (($page>0?$page:1)-1))
            ->setMaxResults($pageSize);

        return $paginator;
    }

//    /**
//     * @return News[] Returns an array of News objects
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

//    public function findOneBySomeField($value): ?News
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
