<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function filter(?array $product_filter = null): array
    {
        $query = $this->createQueryBuilder('p');
        $count = 0;

        if (!empty($product_filter)){
            if (isset($product_filter['name']) && !empty($product_filter['name'])) {
                $query->andWhere('p.name LIKE :name');
                $query->setParameter('name', '%' . $product_filter['name'] . '%');
                $count++;
            }

            if (isset($product_filter['type']) && !empty($product_filter['type'])) {
                $query->andWhere('p.type IN (:type)');
                $query->setParameter('type', $product_filter['type']);
                $count++;
            }

            if (isset($product_filter['priceMin']) && !empty($product_filter['priceMin'])) {
                $query->andWhere('p.price >= :priceMin');
                $query->setParameter('priceMin', $product_filter['priceMin']);
                $count++;
            }

        }

        return [
            'count' => $count,
            'query' => $query
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult()
        ];
    }


    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
