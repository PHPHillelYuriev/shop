<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    //return unique product manufacturer
    public function getUniqueProductManufacturer(int $categoryId)
    {   
        // $dql = "SELECT DISTINCT product.manufacturer FROM App\Entity\Product product WHERE product.category = ($categoryId)";
        // $query = $this->getEntityManager()->createQuery($dql);

        // return $query->getResult();

        return $this->createQueryBuilder('product')
            ->where("product.category = $categoryId")
            ->groupBy('product.manufacturer')
            ->getQuery()
            ->getResult()
            ;
    }

    //return products from array id
    public function getProductsFromArrayId(array $arrayId)
    {
        // $id = implode(',', $arrayId);
        // $dql = "SELECT product FROM App\Entity\Product product WHERE product.id IN($id)";

        // $query = $this->getEntityManager()->createQuery($dql);

        // return $query->getResult();

        return $this->createQueryBuilder('product')
            ->where("product.id IN (:id)")
            ->setParameter('id', $arrayId)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getQueryForPagination(string $data)
    {
        return $this->createQueryBuilder('product')
            ->where("product.category = $data")
            ->getQuery()
            ;

    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
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
    public function findOneBySomeField($value): ?Product
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
